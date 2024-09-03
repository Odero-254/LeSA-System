<?php
// Check if session is not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('includes/config.php');
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (strlen($_SESSION['user_id']) == 0) {
    header('location: logout.php');
    exit();
} else {
    $_SESSION['last_active_time'] = time();

    $alertMessage = '';
    $alertType = '';

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $user_id = $_SESSION['user_id'];
    $userDeptQuery = $conn->prepare("SELECT department_id FROM users WHERE id = ?");
    $userDeptQuery->bind_param("i", $user_id);
    $userDeptQuery->execute();
    $userDeptQuery->bind_result($user_department_id);
    $userDeptQuery->fetch();
    $userDeptQuery->close();

    $lecturersQuery = $conn->prepare("SELECT id, username FROM lecturers WHERE department_id = ?");
    $lecturersQuery->bind_param("i", $user_department_id);
    $lecturersQuery->execute();
    $lecturersResult = $lecturersQuery->get_result();
    $lecturers = $lecturersResult->fetch_all(MYSQLI_ASSOC);
    $lecturersQuery->close();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['allocate_lesson'])) {
            $lecturer_id = $conn->real_escape_string($_POST['lecturer']);
            $subject_id = $conn->real_escape_string($_POST['subject']);
            $class_id = $conn->real_escape_string($_POST['class']);
            $start_time = $conn->real_escape_string($_POST['start_time']);
            $end_time = $conn->real_escape_string($_POST['end_time']);
            $day = $conn->real_escape_string($_POST['day']);

            if (empty($lecturer_id) || empty($subject_id) || empty($class_id) || empty($start_time) || empty($end_time) || empty($day)) {
                $alertMessage = 'All fields are required.';
                $alertType = 'warning';
            } else {
                $start_timestamp = strtotime($start_time);
                $end_timestamp = strtotime($end_time);
                $duration_seconds = $end_timestamp - $start_timestamp;
                $duration = gmdate("H:i:s", $duration_seconds);

                $duplicateQuery = $conn->prepare("SELECT * FROM allocations WHERE lecturer_id = ? AND subject_id = ? AND class_id = ? AND start_time = ? AND end_time = ? AND day_of_week = ?");
                $duplicateQuery->bind_param("iiisss", $lecturer_id, $subject_id, $class_id, $start_time, $end_time, $day);

                $duplicateQuery->execute();
                $duplicateResult = $duplicateQuery->get_result();

                if ($duplicateResult->num_rows > 0) {
                    $alertMessage = 'This lesson has already been allocated.';
                    $alertType = 'info';
                } else {
                    $lecturerDeptQuery = $conn->prepare("SELECT department_id FROM lecturers WHERE id = ?");
                    $lecturerDeptQuery->bind_param("i", $lecturer_id);
                    $lecturerDeptQuery->execute();
                    $lecturerDeptQuery->bind_result($lecturer_department_id);
                    $lecturerDeptQuery->fetch();
                    $lecturerDeptQuery->close();

                    if ($lecturer_department_id == $user_department_id) {
                        $insertQuery = $conn->prepare("INSERT INTO allocations (lecturer_id, subject_id, class_id, start_time, end_time, duration, day_of_week) VALUES (?, ?, ?, ?, ?, ?, ?)");
                        $insertQuery->bind_param("iiissss", $lecturer_id, $subject_id, $class_id, $start_time, $end_time, $duration, $day);

                        if ($insertQuery->execute()) {
                            $alertMessage = 'Lesson allocated successfully.';
                            $alertType = 'success';

                            // Get lecturer email
                            $lecturerEmailQuery = $conn->prepare("SELECT email FROM lecturers WHERE id = ?");
                            $lecturerEmailQuery->bind_param("i", $lecturer_id);
                            $lecturerEmailQuery->execute();
                            $lecturerEmailQuery->bind_result($lecturer_email);
                            $lecturerEmailQuery->fetch();
                            $lecturerEmailQuery->close();

                            // Fetch HOD details
                            $hodQuery = $conn->prepare("SELECT id, email FROM users WHERE user_role = 'HOD' AND department_id = ?");
                            $hodQuery->bind_param("i", $user_department_id);
                            $hodQuery->execute();
                            $hodResult = $hodQuery->get_result();
                            $hod = $hodResult->fetch_assoc();
                            $hodQuery->close();

                            // Prepare email to the lecturer
                            $mail = new PHPMailer(true);
                            try {
                                $mail->isSMTP();
                                $mail->Host = 'smtp.gmail.com';
                                $mail->SMTPAuth = true;
                                $mail->Username = 'benardodero21@gmail.com';
                                $mail->Password = 'nfzm oxyi jstv auxp';
                                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                                $mail->Port = 587;

                                $mail->setFrom('benardodero21@gmail.com', 'LeSAS Admin Team');
                                $mail->addAddress($lecturer_email);

                                $mail->isHTML(true);
                                $mail->Subject = 'Lesson Allocation Notification';
                                $mail->Body = "Dear Lecturer,<br><br>
                                    You have been allocated a lesson.<br>
                                    Subject: $subject_name<br>
                                    Class: $class_name<br>
                                    Course: $course_name<br>
                                    Level: $level_name<br>
                                    Start Time: $start_time<br>
                                    End Time: $end_time<br>
                                    Duration: $duration<br>
                                    Day: $day<br><br>
                                    Kindly keep your Lesson time,<br>
                                    Best regards,<br>
                                    Your School Admin";

                                $mail->send();

                                // Insert notification for the requesting and approving HOD
                                $notificationQuery = $conn->prepare("
                                    INSERT INTO notifications (user_id, message, status) 
                                    VALUES (?, ?, ?), (?, ?, ?)
                                ");
                                $message = "A lesson allocation request has been approved for lecturer with ID $lecturer_id.";
                                $status = "unread";
                                $notificationQuery->bind_param("ississ", $user_id, $message, $status, $hod['id'], $message, $status);
                                $notificationQuery->execute();
                                $notificationQuery->close();
                            } catch (Exception $e) {
                                $alertMessage = 'Error sending email: ' . $mail->ErrorInfo;
                                $alertType = 'danger';
                            }
                        } else {
                            $alertMessage = 'Error: ' . $conn->error;
                            $alertType = 'danger';
                        }
                        $insertQuery->close();
                    } else {
                        $alertMessage = 'Lecturer does not belong to your department.';
                        $alertType = 'warning';
                    }
                }
                $duplicateQuery->close();
            }
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lesson Allocation</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2 class="mt-4">Lesson Allocation</h2>
        <?php if ($alertMessage): ?>
            <div class="alert alert-<?php echo $alertType; ?>"><?php echo $alertMessage; ?></div>
        <?php endif; ?>
        <form id="allocationForm" method="post">
            <div class="form-group">
                <label for="lecturer">Select Lecturer</label>
                <select class="form-control" id="lecturer" name="lecturer" required>
                    <option value="">Select Lecturer</option>
                    <?php foreach ($lecturers as $lecturer): ?>
                        <option value="<?php echo $lecturer['id']; ?>"><?php echo $lecturer['username']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="subject">Select Subject</label>
                <select class="form-control" id="subject" name="subject" required>
                    <option value="">Select Subject</option>
                </select>
            </div>
            <div class="form-group">
                <label for="class">Select Class</label>
                <select class="form-control" id="class" name="class" required>
                    <option value="">Select Class</option>
                    <?php foreach ($classes as $class): ?>
                        <option value="<?php echo $class['id']; ?>"><?php echo $class['class_name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="start_time">Start Time</label>
                <input type="time" class="form-control" id="start_time" name="start_time" required>
            </div>
            <div class="form-group">
                <label for="end_time">End Time</label>
                <input type="time" class="form-control" id="end_time" name="end_time" required>
            </div>
            <div class="form-group">
                <label for="day">Day</label>
                <select class="form-control" id="day" name="day" required>
                    <option value="">Select Day</option>
                    <option value="Monday">Monday</option>
                    <option value="Tuesday">Tuesday</option>
                    <option value="Wednesday">Wednesday</option>
                    <option value="Thursday">Thursday</option>
                    <option value="Friday">Friday</option>
                </select>
            </div>
            <button type="submit" name="allocate_lesson" class="btn btn-primary">Allocate Lesson</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#lecturer').change(function() {
                var lecturer_id = $(this).val();
                if (lecturer_id != "") {
                    $.ajax({
                        url: "fetch_subjects.php",
                        method: "POST",
                        data: {lecturer_id: lecturer_id},
                        success: function(data) {
                            $('#subject').html(data);
                        }
                    });
                } else {
                    $('#subject').html('<option value="">Select Subject</option>');
                }
            });
        });
    </script>
</body>
</html>
