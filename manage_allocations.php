<?php
// Check if session is not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('includes/config.php');
require 'vendor/autoload.php'; // Autoload PHPMailer and other dependencies

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = 'You must be logged in to perform this action.';
    header('Location: login.php');
    exit();
}

// Fetch logged-in user's department ID
$user_id = $_SESSION['user_id'];
$user_query = $conn->prepare("SELECT department_id FROM users WHERE id = ?");
$user_query->bind_param("i", $user_id);
$user_query->execute();
$user_result = $user_query->get_result();
$user = $user_result->fetch_assoc();

if (!$user) {
    $_SESSION['error'] = 'User not found.';
    header('Location: login.php');
    exit();
}

// Update last activity time to extend session
$_SESSION['last_active_time'] = time();

$department_id = $user['department_id'];

// Fetch allocations for the logged-in user's department
$allocations_query = $conn->prepare("
    SELECT a.id, a.lecturer_id, a.subject_id, a.class_id, a.start_time, a.end_time, a.day_of_week,
           l.username AS lecturer_name, s.subject_name AS subject_name, c.class_name
    FROM allocations a
    JOIN lecturers l ON a.lecturer_id = l.id
    JOIN subjects s ON a.subject_id = s.id
    JOIN classes c ON a.class_id = c.id
    WHERE c.department_id = ?
");
$allocations_query->bind_param("i", $department_id);
$allocations_query->execute();
$allocations_result = $allocations_query->get_result();
$allocations = $allocations_result->fetch_all(MYSQLI_ASSOC);

// Function to send notifications
function send_notification($conn, $title, $user_role, $message, $lesson_id, $user_id, $sender_id) {
    $notification_query = $conn->prepare("
        INSERT INTO notifications (title, user_role, message, lesson_id, user_id, sender_id)
        VALUES (?, ?, ?, ?, ?, ?)
    ");
    $notification_query->bind_param("sssiis", $title, $user_role, $message, $lesson_id, $user_id, $sender_id);
    $notification_query->execute();
}

// Function to send email using PHPMailer
function send_email($recipient_email, $subject, $body) {
    $mail = new PHPMailer();
    // PHPMailer configuration
    $mail->isSMTP();
    $mail->Host = 'smtp.example.com'; // Set the SMTP server to send through
    $mail->SMTPAuth = true;
    $mail->Username = 'your_email@example.com'; // SMTP username
    $mail->Password = 'your_email_password'; // SMTP password
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('your_email@example.com', 'Your Name');
    $mail->addAddress($recipient_email);

    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $body;

    if (!$mail->send()) {
        echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
    }
}

// Handle reallocation or correction
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $allocation_id = $_POST['allocation_id'];
    $new_lecturer_id = $_POST['new_lecturer_id'];
    $new_subject_id = $_POST['new_subject_id'];
    $new_start_time = $_POST['new_start_time'];
    $new_end_time = $_POST['new_end_time'];
    $new_day_of_week = $_POST['new_day_of_week'];

    $update_allocation_query = $conn->prepare("
        UPDATE allocations 
        SET lecturer_id = ?, subject_id = ?, start_time = ?, end_time = ?, day_of_week = ?
        WHERE id = ?
    ");
    $update_allocation_query->bind_param("iisssi", $new_lecturer_id, $new_subject_id, $new_start_time, $new_end_time, $new_day_of_week, $allocation_id);
    if ($update_allocation_query->execute()) {
        $_SESSION['success'] = 'Allocation updated successfully.';
    } else {
        $_SESSION['error'] = 'Failed to update allocation.';
    }
    header('Location: manage_allocations.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Allocations</title>
    <link rel="stylesheet" href="path/to/your/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <?php
        if (isset($_SESSION['success'])) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
            echo $_SESSION['success'];
            echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
            echo '<span aria-hidden="true">&times;</span>';
            echo '</button>';
            echo '</div>';
            unset($_SESSION['success']);
        }

        if (isset($_SESSION['error'])) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
            echo $_SESSION['error'];
            echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
            echo '<span aria-hidden="true">&times;</span>';
            echo '</button>';
            echo '</div>';
            unset($_SESSION['error']);
        }
        ?>

        <h2>Manage Allocations</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Class</th>
                    <th>Subject</th>
                    <th>Lecturer</th>
                    <th>Day</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($allocations as $allocation) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($allocation['class_name']); ?></td>
                    <td><?php echo htmlspecialchars($allocation['subject_name']); ?></td>
                    <td><?php echo htmlspecialchars($allocation['lecturer_name']); ?></td>
                    <td><?php echo htmlspecialchars($allocation['day_of_week']); ?></td>
                    <td><?php echo htmlspecialchars($allocation['start_time']); ?></td>
                    <td><?php echo htmlspecialchars($allocation['end_time']); ?></td>
                    <td>
                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModal<?php echo $allocation['id']; ?>">Edit</button>
                    </td>
                </tr>

                <!-- Edit Modal -->
                <div class="modal fade" id="editModal<?php echo $allocation['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel">Edit Allocation</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="manage_allocations.php" method="post">
                                    <input type="hidden" name="allocation_id" value="<?php echo $allocation['id']; ?>">
                                    <div class="form-group">
                                        <label for="new_lecturer_id">New Lecturer</label>
                                        <select class="form-control" name="new_lecturer_id" required>
                                            <!-- Populate with lecturers -->
                                            <?php
                                            $lecturers_query = $conn->query("SELECT id, username FROM lecturers WHERE department_id = $department_id");
                                            while ($lecturer = $lecturers_query->fetch_assoc()) {
                                                echo '<option value="' . $lecturer['id'] . '">' . htmlspecialchars($lecturer['username']) . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="new_subject_id">New Subject</label>
                                        <select class="form-control" name="new_subject_id" required>
                                            <!-- Populate with subjects -->
                                            <?php
                                            $subjects_query = $conn->query("SELECT id, subject_name FROM subjects WHERE department_id = $department_id");
                                            while ($subject = $subjects_query->fetch_assoc()) {
                                                echo '<option value="' . $subject['id'] . '">' . htmlspecialchars($subject['subject_name']) . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="new_start_time">New Start Time</label>
                                        <input type="time" class="form-control" name="new_start_time" value="<?php echo $allocation['start_time']; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="new_end_time">New End Time</label>
                                        <input type="time" class="form-control" name="new_end_time" value="<?php echo $allocation['end_time']; ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="new_day_of_week">New Day of the Week</label>
                                        <select class="form-control" name="new_day_of_week" required>
                                            <option value="Monday" <?php echo $allocation['day_of_week'] == 'Monday' ? 'selected' : ''; ?>>Monday</option>
                                            <option value="Tuesday" <?php echo $allocation['day_of_week'] == 'Tuesday' ? 'selected' : ''; ?>>Tuesday</option>
                                            <option value="Wednesday" <?php echo $allocation['day_of_week'] == 'Wednesday' ? 'selected' : ''; ?>>Wednesday</option>
                                            <option value="Thursday" <?php echo $allocation['day_of_week'] == 'Thursday' ? 'selected' : ''; ?>>Thursday</option>
                                            <option value="Friday" <?php echo $allocation['day_of_week'] == 'Friday' ? 'selected' : ''; ?>>Friday</option>
                                        </select>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Update Allocation</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="path/to/your/js/jquery.min.js"></script>
    <script src="path/to/your/js/bootstrap.bundle.min.js"></script>
    <script>
        var inactiveTimeout = <?php echo 300; ?>;
        var idleTimer;

        function resetIdleTimer() {
            clearTimeout(idleTimer);
            idleTimer = setTimeout(logoutUser, inactiveTimeout * 1000);
        }

        function logoutUser() {
            window.location.href = 'auto_logout.php'; 
        }

        // Set up event listeners to reset idle timer on user activity
        document.addEventListener('mousemove', resetIdleTimer);
        document.addEventListener('mousedown', resetIdleTimer);
        document.addEventListener('keypress', resetIdleTimer);
        document.addEventListener('scroll', resetIdleTimer);

        // Initialize the idle timer on page load
        resetIdleTimer();
    </script>
</body>
</html>

