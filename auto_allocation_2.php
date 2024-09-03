<?php
include 'includes/config.php'; 

// Check if session is not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$user_id = $_SESSION['user_id'];

// Step 1: Fetch the logged-in user's department ID
$department_query = $conn->prepare("SELECT department_id FROM users WHERE id = ?");
$department_query->bind_param("i", $user_id);
$department_query->execute();
$department_query->bind_result($logged_in_department_id);
$department_query->fetch();
$department_query->close();

// Step 2: Check for Active Term
$term_query = $conn->query("SELECT start_date, end_date FROM term_dates WHERE status = 'running' LIMIT 1");
if ($term_query->num_rows == 0) {
    echo "<script>alert('No active term found! Allocations cannot be made.'); window.location.href='dashboard.php';</script>";
    exit();
}
$term = $term_query->fetch_assoc();
$start_date = $term['start_date'];
$end_date = $term['end_date'];

// Step 3: Fetch Classes and Subjects
$classes_query = $conn->prepare("SELECT id, class_name, course_id, level_id FROM classes WHERE department_id = ?");
$classes_query->bind_param("i", $logged_in_department_id);
$classes_query->execute();
$classes_result = $classes_query->get_result();

$subjects_query = $conn->prepare("SELECT id, subject_name FROM subjects WHERE department_id = ?");
$subjects_query->bind_param("i", $logged_in_department_id);
$subjects_query->execute();
$subjects_result = $subjects_query->get_result();

// Step 4: Verify Qualified Lecturers
$qualified_lecturers_query = $conn->prepare("
    SELECT l.id AS lecturer_id, l.user_id, s.subject_name 
    FROM lecturers l 
    JOIN lecturer_subjects ls ON l.id = ls.lecturer_id 
    JOIN subjects s ON ls.subject_id = s.id 
    WHERE l.department_id = ? AND s.department_id = ?
");
$qualified_lecturers_query->bind_param("ii", $logged_in_department_id, $logged_in_department_id);
$qualified_lecturers_query->execute();
$qualified_lecturers_result = $qualified_lecturers_query->get_result();

// Prepare an array to hold qualified lecturers by subject
$lecturers_by_subject = [];
while ($lecturer = $qualified_lecturers_result->fetch_assoc()) {
    $lecturers_by_subject[$lecturer['subject_name']][] = $lecturer;
}

// Step 5: Perform Allocations
$allocation_errors = [];
$allocated_classes = [];

while ($class = $classes_result->fetch_assoc()) {
    $class_id = $class['id'];
    $class_name = $class['class_name'];
    $course_id = $class['course_id'];
    $level_id = $class['level_id'];
    $allocated = false;

    foreach ($subjects_result as $subject) {
        $subject_id = $subject['id'];
        $subject_name = $subject['subject_name'];
        
        // Allocate to a qualified lecturer for this subject
        if (isset($lecturers_by_subject[$subject_name])) {
            foreach ($lecturers_by_subject[$subject_name] as $lecturer) {
                $lecturer_id = $lecturer['lecturer_id'];

                // Define possible time slots
                $time_slots = [
                    ["08:00:00", "10:00:00"], 
                    ["10:15:00", "12:15:00"], 
                    ["13:15:00", "15:15:00"], 
                    ["15:30:00", "17:30:00"]
                ];

                for ($day = 1; $day <= 5; $day++) {
                    foreach ($time_slots as $slot) {
                        $start_time = $slot[0];
                        $end_time = $slot[1];
                        $duration = "02:00:00";

                        // Check for conflicting allocations
                        $conflict_query = $conn->prepare("
                            SELECT 1 
                            FROM allocations 
                            WHERE 
                                class_id = ? AND 
                                (start_time = ? AND end_time = ?) AND 
                                day_of_week = ?
                        ");
                        $conflict_query->bind_param("isss", $class_id, $start_time, $end_time, $day);
                        $conflict_query->execute();
                        $conflict_query->store_result();

                        if ($conflict_query->num_rows == 0) {
                            // Insert the allocation
                            $allocation_query = $conn->prepare("
                                INSERT INTO allocations 
                                (lecturer_id, subject_id, class_id, course, level, start_time, end_time, duration, day_of_week) 
                                VALUES 
                                (?, ?, ?, (SELECT course_name FROM courses WHERE id = ?), (SELECT name FROM levels WHERE id = ?), ?, ?, ?, ?)
                            ");
                            $allocation_query->bind_param("iiiisssss", 
                                $lecturer_id, $subject_id, $class_id, $course_id, $level_id, $start_time, $end_time, $duration, $day);
                            $allocation_query->execute();
                            $allocated = true;
                        }
                    }
                }
                break; // Stop checking other lecturers once a match is found
            }
        } else {
            $allocation_errors[] = "No qualified lecturer found for $subject_name in $class_name.";
        }
    }

    if ($allocated) {
        $allocated_classes[] = $class_name;
    }
}

// Step 6: Send Notifications and Emails
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);

if (!empty($allocated_classes)) {
    foreach ($lecturers_by_subject as $subject_name => $lecturers) {
        foreach ($lecturers as $lecturer) {
            $lecturer_id = $lecturer['lecturer_id'];
            $user_id = $lecturer['user_id'];
            
            // Fetch lecturer's email
            $email_query = $conn->prepare("SELECT email FROM users WHERE id = ?");
            $email_query->bind_param("i", $user_id);
            $email_query->execute();
            $email_query->bind_result($email);
            $email_query->fetch();

            // Compose email and notification
            $allocations = "";
            foreach ($allocated_classes as $allocated_class) {
                $allocations .= "$allocated_class - $subject_name<br>";
            }

            $message = "Dear Lecturer,<br><br>The following classes have been allocated to you:<br>$allocations";

            // Send email
            try {
                $mail->setFrom('benardodero21@gmail.com', 'NYSEI LeSA Admin Team');
                $mail->addAddress($email);
                $mail->Subject = 'Class Allocation';
                $mail->Body    = $message;
                $mail->send();
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }

            // Store notification in the database
            $notification_query = $conn->prepare("
                INSERT INTO notifications 
                (title, user_role, message, link, status, notification_time, user_id, sender_id, is_sent) 
                VALUES 
                ('Lesson Allocation', 'Lecturer', ?, '', 'Unread', NOW(), ?, ?, 1)
            ");
            $notification_query->bind_param("sii", $message, $user_id, $user_id);
            $notification_query->execute();
        }
    }
}

// Step 7: Handle Unqualified Lecturers
if (!empty($allocation_errors)) {
    echo "<h3>Allocation Errors:</h3>";
    foreach ($allocation_errors as $error) {
        echo "<p>$error</p>";
    }
}

// Handle case where no qualified lecturers in the department
$cross_department_query = $conn->prepare("
SELECT l.id, l.username, d.name 
FROM lecturers l 
JOIN department d ON l.department_id = d.id 
WHERE l.id IN (
    SELECT lecturer_id FROM lecturer_subjects 
    WHERE subject_id IN (
        SELECT id FROM subjects WHERE department_id = ?
    )
)");
$cross_department_query->bind_param("i", $logged_in_department_id);
$cross_department_query->execute();
$cross_department_result = $cross_department_query->get_result();

if ($cross_department_result->num_rows > 0) {
    echo "<h3>Lecturers in Other Departments Who Qualify:</h3>";
    echo "<table border='1'>";
    echo "<tr><th>Lecturer</th><th>Department</th><th>Action</th></tr>";

    while ($row = $cross_department_result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['username']) . "</td>";
        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
        echo "<td><a href='request_lecturer.php?lecturer_id=" . $row['id'] . "'>
                  <button>Request Lecturer</button>
              </a></td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<h3>No lecturers available in other departments qualify for the required subjects.</h3>";
}
?>
