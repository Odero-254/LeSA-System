<?php
// Set up error handling
set_error_handler(function($errno, $errstr, $errfile, $errline) {
    echo "<script>alert('Error: $errstr in $errfile on line $errline');</script>";
    error_log("Error: [$errno] $errstr in $errfile on line $errline", 0);
});

// Database connection
$conn = new mysqli("localhost", "username", "password", "nysei_lesa");
if ($conn->connect_error) {
    die("<script>alert('Database connection failed.');</script>");
}

// Start session and get logged-in user details
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';
// Check if session is not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$logged_in_user_department_id = $_SESSION['department_id'];

// Check for an active term
$term_check_query = "SELECT * FROM term_dates WHERE status = 'running'";
$term_check_result = $conn->query($term_check_query);

if ($term_check_result->num_rows === 0) {
    echo "<script>alert('No active term found. Allocation cannot proceed.');</script>";
    exit;
} else {
    $term_data = $term_check_result->fetch_assoc();
    $term_start_date = $term_data['start_date'];
    $term_end_date = $term_data['end_date'];
}

// Fetch classes based on the logged-in user's department
$classes_query = "SELECT * FROM classes WHERE department_id = $logged_in_user_department_id";
$classes_result = $conn->query($classes_query);

while ($class = $classes_result->fetch_assoc()) {
    $class_id = $class['id'];
    $class_name = $class['class_name'];
    $course_id = $class['course_id'];
    $level_id = $class['level_id'];

    // Fetch subjects for the class
    $subjects_query = "SELECT * FROM subjects WHERE department_id = $logged_in_user_department_id";
    $subjects_result = $conn->query($subjects_query);

    while ($subject = $subjects_result->fetch_assoc()) {
        $subject_id = $subject['id'];
        $subject_name = $subject['name'];

        // Fetch lecturers who can teach the subject
        $lecturer_subjects_query = "SELECT lecturer_id FROM lecturer_subjects WHERE subject_id = $subject_id";
        $lecturer_subjects_result = $conn->query($lecturer_subjects_query);

        while ($lecturer_subject = $lecturer_subjects_result->fetch_assoc()) {
            $lecturer_id = $lecturer_subject['lecturer_id'];

            // Check for scheduling conflicts
            $time_slots = [
                ["08:00:00", "10:00:00"],
                ["10:15:00", "12:15:00"],
                ["13:15:00", "15:15:00"],
                ["15:30:00", "17:30:00"]
            ];
            $days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday"];

            foreach ($days as $day) {
                if (!resolveConflict($conn, $lecturer_id, $class_id, $subject_id, $day, $time_slots, $course_id, $level_id, $subject_name, $class_name)) {
                    echo "<script>alert('Conflict could not be resolved for $subject_name in $class_name on $day. Please check manually.');</script>";
                }
            }
        }
    }
}

// Send notifications and emails
sendNotificationsAndEmails($conn, $logged_in_user_department_id);

echo "<script>alert('Allocation process completed successfully.');</script>";

// Restore error handler
restore_error_handler();

// Functions
function resolveConflict($conn, $lecturer_id, $class_id, $subject_id, $day, $time_slots, $course_id, $level_id, $subject_name, $class_name) {
    foreach ($time_slots as $slot) {
        $start_time = $slot[0];
        $end_time = $slot[1];

        // Check for conflicts again
        $conflict_query = $conn->prepare("
            SELECT * FROM allocations 
            WHERE (lecturer_id = ? AND day_of_week = ? AND ((start_time <= ? AND end_time > ?) OR (start_time < ? AND end_time >= ?))) 
            OR (class_id = ? AND day_of_week = ? AND ((start_time <= ? AND end_time > ?) OR (start_time < ? AND end_time >= ?)))
        ");
        $conflict_query->bind_param("issssissssss", 
            $lecturer_id, $day, $start_time, $start_time, $end_time, $end_time, 
            $class_id, $day, $start_time, $start_time, $end_time, $end_time
        );
        $conflict_query->execute();
        $conflict_result = $conflict_query->get_result();

        if ($conflict_result->num_rows === 0) {
            // No conflicts, proceed with allocation
            $allocation_query = $conn->prepare("
                INSERT INTO allocations 
                (lecturer_id, subject_id, class_id, course, level, start_time, end_time, duration, day_of_week)
                VALUES (?, ?, ?, (SELECT course_name FROM courses WHERE id = ?), (SELECT name FROM levels WHERE id = ?), ?, ?, '02:00:00', ?)
            ");
            $allocation_query->bind_param("iiiisss", 
                $lecturer_id, $subject_id, $class_id, $course_id, $level_id, 
                $start_time, $end_time, $day
            );

            if ($allocation_query->execute()) {
                return true;
            } else {
                echo "<script>alert('Failed to allocate $subject_name for $class_name on $day at $start_time - $end_time.');</script>";
                return false;
            }
        }
    }

    return false;
}

function sendNotificationsAndEmails($conn, $department_id) {
    // Fetch all lecturers in the department
    $lecturers_query = "SELECT * FROM lecturers WHERE department_id = $department_id";
    $lecturers_result = $conn->query($lecturers_query);

    while ($lecturer = $lecturers_result->fetch_assoc()) {
        $lecturer_id = $lecturer['id'];
        $user_id = $lecturer['user_id'];

        // Fetch email address of the lecturer
        $email_query = $conn->prepare("SELECT email FROM users WHERE id = ?");
        $email_query->bind_param("i", $user_id);
        $email_query->execute();
        $email_result = $email_query->get_result();
        $email_data = $email_result->fetch_assoc();
        $lecturer_email = $email_data['email'];

        // Fetch all allocations for the lecturer
        $allocations_query = $conn->prepare("
            SELECT a.*, c.class_name, s.name AS subject_name
            FROM allocations a
            JOIN classes c ON a.class_id = c.id
            JOIN subjects s ON a.subject_id = s.id
            WHERE lecturer_id = ?
        ");
        $allocations_query->bind_param("i", $lecturer_id);
        $allocations_query->execute();
        $allocations_result = $allocations_query->get_result();

        $allocations_details = [];
        while ($allocation = $allocations_result->fetch_assoc()) {
            $allocations_details[] = "Class: {$allocation['class_name']}, Subject: {$allocation['subject_name']}, Start Time: {$allocation['start_time']}, End Time: {$allocation['end_time']}, Duration: {$allocation['duration']}, Day: {$allocation['day_of_week']}";
        }

        if (!empty($allocations_details)) {
            // Send email using PHPMailer
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.example.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'your-email@example.com';
                $mail->Password = 'your-email-password';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('your-email@example.com', 'Lesson Allocation System');
                $mail->addAddress($lecturer_email);

                $mail->isHTML(true);
                $mail->Subject = 'Lesson Allocations';
                $mail->Body = "Dear Lecturer,<br><br>You have been allocated the following lessons:<br><br>" . implode('<br>', $allocations_details);

                $mail->send();
            } catch (Exception $e) {
                echo "<script>alert('Email could not be sent. Mailer Error: {$mail->ErrorInfo}');</script>";
            }

            // Insert notification
            $message = "You have been allocated the following lessons: " . implode(', ', $allocations_details);
            $notification_query = $conn->prepare("
                INSERT INTO notifications (title, user_role, message, link, status, notification_time, user_id, sender_id, is_sent)
                VALUES ('Lesson Allocation', 'lecturer', ?, '#', 'unread', NOW(), ?, NULL, 1)
            ");
            $notification_query->bind_param("si", $message, $user_id);
            $notification_query->execute();
        }
    }
}

?>
