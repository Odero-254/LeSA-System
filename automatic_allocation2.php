<?php
// Check if session is not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require 'includes/config.php'; // Database configuration
require 'vendor/autoload.php'; // Include PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Function to send email notification
function sendEmail($to, $subject, $body) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Set the SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'benardodero21@gmail.com'; // SMTP username
        $mail->Password = 'nfzm oxyi jstv auxp'; // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        //Recipients
        $mail->setFrom('benardodero21@gmail.com', 'LeSA Admin');
        $mail->addAddress($to); 

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;

        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

// Check for active term
$query = "SELECT * FROM term_dates WHERE status = 'running' LIMIT 1";
$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) == 0) {
    echo "<script>alert('No active term found. Allocations cannot proceed.');</script>";
    exit;
}

// Get logged-in user's department ID
$user_id = $_SESSION['user_id']; // Assuming user ID is stored in session
$user_query = "SELECT department_id FROM lecturers WHERE user_id = '$user_id'";
$user_result = mysqli_query($conn, $user_query);
$user_data = mysqli_fetch_assoc($user_result);

// Check if user data was found
if (!$user_data) {
    echo "<script>alert('User not found.');</script>";
    exit;
}

$department_id = $user_data['department_id'];

// Get classes from the same department
$classes_query = "SELECT * FROM classes WHERE department_id = '$department_id'";
$classes_result = mysqli_query($conn, $classes_query);

// Check if classes were found
if (mysqli_num_rows($classes_result) == 0) {
    echo "<script>alert('No classes found for your department.');</script>";
    exit;
}

// Get lecturers from the same department
$lecturers_query = "SELECT * FROM lecturers WHERE department_id = '$department_id'";
$lecturers_result = mysqli_query($conn, $lecturers_query);

// Allocate classes
while ($class = mysqli_fetch_assoc($classes_result)) {
    $class_id = $class['id'];
    $class_name = $class['class_name'];

    // Get subjects for the class
    $subjects_query = "SELECT * FROM subjects WHERE department_id = '$department_id' AND class_id = '$class_id'";
    $subjects_result = mysqli_query($conn, $subjects_query);

    // Check if subjects were found
    if (mysqli_num_rows($subjects_result) == 0) {
        echo "<script>alert('No subjects found for class $class_name.');</script>";
        continue; // Skip to the next class
    }

    // Allocate time slots
    $time_slots = [
        'Monday' => ['08:00', '10:00', '10:15', '12:15', '13:15', '15:15', '15:30', '17:30'],
        'Tuesday' => ['08:00', '10:00', '10:15', '12:15', '13:15', '15:15', '15:30', '17:30'],
        'Wednesday' => ['08:00', '10:00', '10:15', '12:15', '13:15', '15:15', '15:30', '17:30'],
        'Thursday' => ['08:00', '10:00', '10:15', '12:15', '13:15', '15:15', '15:30', '17:30'],
        'Friday' => ['08:00', '10:00', '10:15', '12:15', '13:15', '15:15', '15:30', '17:30']
    ];

    while ($subject = mysqli_fetch_assoc($subjects_result)) {
        $subject_id = $subject['id'];
        $subject_name = $subject['name'];

        // Check for eligible lecturers
        $eligible_lecturers_query = "SELECT l.id AS lecturer_id, u.email, d.name AS department_name 
                                      FROM lecturers l 
                                      JOIN users u ON l.user_id = u.id 
                                      JOIN department d ON l.department_id = d.id 
                                      JOIN lecturer_subjects ls ON l.id = ls.lecturer_id 
                                      WHERE ls.subject_id = '$subject_id'";
        $eligible_lecturers_result = mysqli_query($conn, $eligible_lecturers_query);

        // Check if eligible lecturers were found
        if (mysqli_num_rows($eligible_lecturers_result) == 0) {
            echo "<script>alert('No eligible lecturers found for subject $subject_name.');</script>";
            continue; // Skip to the next subject
        }

        while ($lecturer = mysqli_fetch_assoc($eligible_lecturers_result)) {
            $lecturer_id = $lecturer['lecturer_id'];
            $lecturer_email = $lecturer['email'];
            $lecturer_department = $lecturer['department_name'];

            // Allocate time slots
            foreach ($time_slots as $day => $times) {
                for ($i = 0; $i < count($times) - 1; $i += 2) {
                    $start_time = $times[$i];
                    $end_time = $times[$i + 1];
                    $duration = "2 hours"; // Fixed duration

                    // Check for existing allocations
                    $allocation_query = "SELECT * FROM allocations 
                                         WHERE class_id = '$class_id' 
                                         AND subject_id = '$subject_id' 
                                         AND lecturer_id = '$lecturer_id' 
                                         AND start_time = '$start_time' 
                                         AND end_time = '$end_time'";
                    $allocation_result = mysqli_query($conn, $allocation_query);

                    if (mysqli_num_rows($allocation_result) > 0) {
                        echo "<script>alert('Allocation for $subject_name in $class_name at $start_time - $end_time already exists.');</script>";
                    } else {
                        // Insert allocation
                        $insert_query = "INSERT INTO allocations (lecturer_id, subject_id, class_id, course, level, start_time, end_time, duration, day_of_week) 
                                         VALUES ('$lecturer_id', '$subject_id', '$class_id', '$course', '$level', '$start_time', '$end_time', '$duration', '$day')";
                        mysqli_query($conn, $insert_query);
                        
                        // Prepare email content
                        $email_subject = "Lesson Allocation Notification";
                        $email_body = "You have been allocated to teach $subject_name for $class_name on $day from $start_time to $end_time. Duration: $duration.";

                        // Send email
                        sendEmail($lecturer_email, $email_subject, $email_body);
                        
                        // Insert notification
                        $notification_query = "INSERT INTO notifications (title, user_role, message, link, status, notification_time, lesson_id, user_id, sender_id, is_sent) 
                                               VALUES ('Lesson Allocation', 'lecturer', '$email_body', '', 'unread', NOW(), NULL, '$user_id', NULL, 1)";
                        mysqli_query($conn, $notification_query);
                    }
                }
            }
        }

        // Check for unqualified lecturers
        $unqualified_lecturers_query = "SELECT l.username, d.name AS department_name 
                                        FROM lecturers l 
                                        JOIN department d ON l.department_id = d.id 
                                        WHERE l.id NOT IN (SELECT lecturer_id FROM lecturer_subjects WHERE subject_id = '$subject_id')";
        $unqualified_lecturers_result = mysqli_query($conn, $unqualified_lecturers_query);
        if (mysqli_num_rows($unqualified_lecturers_result) > 0) {
            echo "<table>";
            echo "<tr><th>Lecturer Name</th><th>Department</th><th>Action</th></tr>";
            while ($unqualified = mysqli_fetch_assoc($unqualified_lecturers_result)) {
                echo "<tr>";
                echo "<td>" . $unqualified['username'] . "</td>";
                echo "<td>" . $unqualified['department_name'] . "</td>";
                echo "<td><button>Request Approval</button></td>";
                echo "</tr>";
            }
            echo "</table>";
        }
    }
}
?>