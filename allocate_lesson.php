<?php
// Check if session is not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require 'includes/config.php';
require 'vendor/autoload.php'; // Autoload the PHPMailer classes

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Function to send email using PHPMailer
function sendEmail($to, $subject, $body) {
    $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Update with your SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'benardodero21@gmail.com'; // Update with your email
        $mail->Password = 'nfzm oxyi jstv auxp'; // Update with your email password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('benardodero21@gmail.com', 'NYSEI LeSA Team'); // Update with your email
        $mail->addAddress($to);

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Email could not be sent. Mailer Error: {$mail->ErrorInfo}");
        return false;
    }
}

$course_name = '';
$level_name = '';

// Fetch class, course, and level information
if (isset($_GET['class_id'])) {
    $class_id = $_GET['class_id'];

    // Fetch course_id and level_id from classes table
    $query = "SELECT course_id, level_id FROM classes WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $class_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $course_id = $row['course_id'];
        $level_id = $row['level_id'];

        // Fetch course_name from courses table
        $query = "SELECT course_name FROM courses WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $course_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $course_name = $row['course_name'];
        }

        // Fetch level_name from levels table
        $query = "SELECT level FROM levels WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $level_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $level_name = $row['level'];
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $lecturer_id = $_POST['lecturer_id'] ?? null;
    $subject_id = $_POST['subject_id'] ?? null;
    $class_id = $_POST['class_id'] ?? null;
    $course = $_POST['course'] ?? '';
    $level = $_POST['level'] ?? '';
    $start_time = $_POST['start_time'] ?? '';
    $end_time = $_POST['end_time'] ?? '';
    $day_of_week = $_POST['day_of_week'] ?? '';

    // Ensure that necessary values are not null
    if ($lecturer_id && $subject_id && $class_id && $course && $level && $start_time && $end_time && $day_of_week) {
        // Fetch term dates
        $query = "SELECT start_date, end_date FROM term_dates ORDER BY start_date DESC LIMIT 1";
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            $term_dates = $result->fetch_assoc();
            $term_start = $term_dates['start_date'];
            $term_end = $term_dates['end_date'];

            // Validate allocation times
            $start_date_time = date('Y-m-d') . ' ' . $start_time;
            $end_date_time = date('Y-m-d') . ' ' . $end_time;
            if ($start_date_time < $term_start || $end_date_time > $term_end) {
                $message = "The selected times must be within the term dates.";
            } else {
                // Check for overlapping allocations for the same subject in the same class
                $query = "SELECT * FROM allocations WHERE class_id = ? AND subject_id = ? AND day_of_week = ? AND 
                          ((start_time <= ? AND end_time >= ?) OR (start_time <= ? AND end_time >= ?))";
                $stmt = $conn->prepare($query);
                $stmt->bind_param('iisssss', $class_id, $subject_id, $day_of_week, $start_time, $end_time, $start_time, $end_time);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $message = "This subject is already allocated during this time for this class.";
                } else {
                    // Check for existing allocation for the same lecturer
                    $query = "SELECT * FROM allocations WHERE lecturer_id = ? AND class_id = ? AND day_of_week = ? AND 
                              ((start_time <= ? AND end_time >= ?) OR (start_time <= ? AND end_time >= ?))";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param('iisssss', $lecturer_id, $class_id, $day_of_week, $start_time, $end_time, $start_time, $end_time);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        $message = "This lecturer is already allocated during this time.";
                    } else {
                        $duration = (strtotime($end_time) - strtotime($start_time)) / 60; // in minutes
                        $query = "INSERT INTO allocations (lecturer_id, subject_id, class_id, course, level, start_time, end_time, duration, day_of_week) 
                                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                        $stmt = $conn->prepare($query);
                        $stmt->bind_param('iiissssis', $lecturer_id, $subject_id, $class_id, $course, $level, $start_time, $end_time, $duration, $day_of_week);
                        if ($stmt->execute()) {
                            $message = "Lesson allocated successfully.";

                            // Fetch lecturer email
                            $query = "SELECT u.email FROM lecturers l JOIN users u ON l.user_id = u.id WHERE l.id = ?";
                            $stmt = $conn->prepare($query);
                            $stmt->bind_param('i', $lecturer_id);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $row = $result->fetch_assoc();
                            $lecturer_email = $row['email'];

                            // Prepare notification
                            $title = "New Lesson Allocation";
                            $notification_message = "You have been allocated a new lesson.<br>Class: $class_id<br>Subject: $subject_id<br>Start Time: $start_time<br>End Time: $end_time<br>Duration: $duration minutes<br>Day: $day_of_week<br>";
                            $link = 'send_message.php';
                            $sender_id = $_SESSION['user_id'];
                            $user_role = 'lecturer';
                            $lesson_id = $stmt->insert_id;
                            $status = 'unread';

                            // Insert notification into notifications table
                            $query = "INSERT INTO notifications (title, user_role, message, link, status, lesson_id, user_id, sender_id) 
                                      VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                            $stmt = $conn->prepare($query);
                            $stmt->bind_param('sssssiis', $title, $user_role, $notification_message, $link, $status, $lesson_id, $lecturer_id, $sender_id);
                            if (!$stmt->execute()) {
                                error_log("Error inserting notification: " . $stmt->error);
                            }

                            // Send email notification
                            $email_body = "You have been allocated a new lesson.<br>Class: $class_id<br>Subject: $subject_id<br>Start Time: $start_time<br>End Time: $end_time<br>Duration: $duration minutes<br>Day: $day_of_week<br>";
                            if (!sendEmail($lecturer_email, $title, $email_body)) {
                                $message .= " However, there was an issue sending the email notification.";
                            }

                            // Check for other qualified lecturers
                            $query = "SELECT l.id AS lecturer_id, u.email, u.id AS hod_id FROM lecturer_subjects ls 
                                      JOIN lecturers l ON ls.lecturer_id = l.id 
                                      JOIN users u ON l.user_id = u.id 
                                      WHERE ls.subject_id = ? AND u.department_id != ? AND u.user_role = 'lecturer'";
                            $stmt = $conn->prepare($query);
                            $stmt->bind_param('ii', $subject_id, $_SESSION['department_id']);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $hod_id = $row['hod_id'];
                                    $lecturer_email = $row['email'];
                                    $notification_message = "Request to allocate a lecturer.<br>Lecturer: " . $row['lecturer_id'] . "<br>Subject: $subject_id<br>Start Time: $start_time<br>End Time: $end_time<br>Duration: $duration minutes<br>Day: $day_of_week<br>";
                                    $link = 'approve_allocation.php';
                                    $user_role = 'HOD';

                                    // Insert notification into notifications table
                                    $query = "INSERT INTO notifications (title, user_role, message, link, status, lesson_id, user_id, sender_id) 
                                              VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                                    $stmt = $conn->prepare($query);
                                    $stmt->bind_param('sssssiis', $title, $user_role, $notification_message, $link, $status, $lesson_id, $hod_id, $sender_id);
                                    if (!$stmt->execute()) {
                                        error_log("Error inserting notification for HOD: " . $stmt->error);
                                    }

                                    // Send email notification to HOD
                                    if (!sendEmail($lecturer_email, $title, $notification_message)) {
                                        $message .= " Notification email to HOD could not be sent.";
                                    }
                                }
                            }
                        } else {
                            $message = "Failed to allocate lesson.";
                        }
                    }
                }
            }
        } else {
            $message = "Term dates are not set.";
        }
    } else {
        $message = "Missing required data for allocation.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Allocate Lesson</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Allocate Lesson</h1>
    <form method="POST" action="allocate_lesson.php">
        <input type="hidden" name="lecturer_id" value="<?php echo htmlspecialchars($_GET['lecturer_id'] ?? ''); ?>">
        <input type="hidden" name="subject_id" value="<?php echo htmlspecialchars($_GET['subject_id'] ?? ''); ?>">
        <input type="hidden" name="class_id" value="<?php echo htmlspecialchars($_GET['class_id'] ?? ''); ?>">
        <div>
            <label for="course">Course:</label>
            <input type="text" name="course" id="course" value="<?php echo htmlspecialchars($course_name); ?>" required readonly>
        </div>
        <div>
            <label for="level">Level:</label>
            <input type="text" name="level" id="level" value="<?php echo htmlspecialchars($level_name); ?>" required readonly>
        </div>
        <div>
            <label for="start_time">Start Time:</label>
            <input type="time" name="start_time" id="start_time" required>
        </div>
        <div>
            <label for="end_time">End Time:</label>
            <input type="time" name="end_time" id="end_time" required>
        </div>
        <div>
            <label for="day_of_week">Day of Week:</label>
            <select name="day_of_week" id="day_of_week" required>
                <option value="Monday">Monday</option>
                <option value="Tuesday">Tuesday</option>
                <option value="Wednesday">Wednesday</option>
                <option value="Thursday">Thursday</option>
                <option value="Friday">Friday</option>
            </select>
        </div>
        <button type="submit">Allocate Lesson</button>
    </form>
    <?php if (isset($message)): ?>
        <p><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>
</body>
</html>
