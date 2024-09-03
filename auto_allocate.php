<?php
// Check if session is not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('includes/config.php');
require 'vendor/autoload.php'; // Autoload PHPMailer and other dependencies

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

set_time_limit(120); // Set a maximum execution time of 2 minutes

// Function to send notifications
function send_notification($conn, $title, $user_role, $message, $lesson_id, $user_id, $sender_id) {
    if ($lesson_id !== null) {
        // If lesson_id is provided, include it in the query
        $notification_query = $conn->prepare("
            INSERT INTO notifications (title, user_role, message, lesson_id, user_id, sender_id)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $notification_query->bind_param("sssiis", $title, $user_role, $message, $lesson_id, $user_id, $sender_id);
    } else {
        // If lesson_id is null, exclude it from the query
        $notification_query = $conn->prepare("
            INSERT INTO notifications (title, user_role, message, user_id, sender_id)
            VALUES (?, ?, ?, ?, ?)
        ");
        $notification_query->bind_param("sssii", $title, $user_role, $message, $user_id, $sender_id);
    }

    $notification_query->execute();
    $notification_query->close(); // Close statement
}

// Function to send email using PHPMailer
function send_email($recipient_email, $subject, $body) {
    $mail = new PHPMailer();
    // PHPMailer configuration
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'benardodero21@gmail.com';
    $mail->Password = 'nfzm oxyi jstv auxp';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom('benardodero21@gmail.com', 'NYSEI Admin Team');
    $mail->addAddress($recipient_email);

    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body    = $body;

    if (!$mail->send()) {
        echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo, "<br>";
    }
}

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = "You must be logged in to perform this action.";
    header('Location: login.php');
    exit();
}

// Fetch logged-in user's department ID
$user_id = $_SESSION['user_id'];
$user_query = $conn->prepare("SELECT department_id, email FROM users WHERE id = ?");
$user_query->bind_param("i", $user_id);
$user_query->execute();
$user_result = $user_query->get_result();
$user = $user_result->fetch_assoc();
$user_query->close(); // Close statement

if (!$user) {
    $_SESSION['error'] = "User not found.";
    header('Location: login.php');
    exit();
}

$department_id = $user['department_id'];
$user_email = $user['email']; // Get logged-in user's email

// Flags to ensure notification and email are sent only once
$notification_sent = false;
$email_sent = false;

// Fetch current term dates
echo "Fetching current term dates...<br>";
$term_dates_query = $conn->query("SELECT * FROM term_dates WHERE status = 'running'");
$term_dates = $term_dates_query->fetch_assoc();
$term_dates_query->close(); // Close statement

if (!$term_dates) {
    $_SESSION['error'] = "No current term dates found.";
    header('Location: home.php');
    exit();
}

$start_date = $term_dates['start_date'];
$end_date = $term_dates['end_date'];

// Fetch classes for the logged-in user's department
echo "Fetching classes for the department...<br>";
$class_query = $conn->prepare("SELECT * FROM classes WHERE department_id = ?");
$class_query->bind_param("i", $department_id);
$class_query->execute();
$class_result = $class_query->get_result();
$classes = $class_result->fetch_all(MYSQLI_ASSOC);
$class_query->close(); // Close statement

// Fetch lecturer subjects along with subject names
echo "Fetching lecturer subjects...<br>";
$lecturer_subject_query = $conn->prepare("
    SELECT ls.lecturer_id, ls.subject_id, l.department_id, u.email AS lecturer_email, s.subject_name AS subject_name, s.class_id AS subject_class_id
    FROM lecturer_subjects ls
    JOIN lecturers l ON ls.lecturer_id = l.id
    JOIN users u ON l.user_id = u.id
    JOIN subjects s ON ls.subject_id = s.id
    WHERE s.class_id IN (SELECT id FROM classes WHERE department_id = ?)
");
$lecturer_subject_query->bind_param("i", $department_id);
$lecturer_subject_query->execute();
$lecturer_subject_result = $lecturer_subject_query->get_result();
$lecturer_subjects = $lecturer_subject_result->fetch_all(MYSQLI_ASSOC);
$lecturer_subject_query->close(); // Close statement

// Allocate lessons
echo "Allocating lessons...<br>";
$days_of_week = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
$lesson_times = [
    ['08:00:00', '10:00:00'], // First lesson
    ['10:15:00', '12:15:00'], // Second lesson
    ['13:15:00', '15:15:00'], // Third lesson
    ['15:30:00', '17:30:00'], // Fourth lesson
    ['17:45:00', '18:30:00']  // Games
];

// Array to keep track of emailed lecturers
$emailed_lecturers = [];

foreach ($classes as $class) {
    $class_id = $class['id'];
    $class_name = $class['class_name'];
    $course_id = $class['course_id'];
    $level_id = $class['level_id'];
    $allocated_subjects = [];

    foreach ($days_of_week as $day) {
        foreach ($lesson_times as $index => $times) {
            list($start_time, $end_time) = $times;
            $duration = (strtotime($end_time) - strtotime($start_time)) / 60; // duration in minutes

            // Check if lesson time is within the term dates
            $lesson_date = date('Y-m-d'); // Assuming lesson date needs to be within term dates; adjust as necessary
            if ($lesson_date < $start_date || $lesson_date > $end_date) {
                continue; // Skip lessons outside term dates
            }

            // Find a lecturer who can teach a subject in this class and hasn't been allocated yet
            $allocated = false;
            foreach ($lecturer_subjects as $ls) {
                $lecturer_id = $ls['lecturer_id'];
                $subject_id = $ls['subject_id'];
                $subject_name = $ls['subject_name'];
                $lecturer_department_id = $ls['department_id'];
                $lecturer_email = $ls['lecturer_email'];
                $subject_class_id = $ls['subject_class_id'];

                // Validation 4: Subjects should only be allocated to those classes with the same class ID as that of the subject
                if ($subject_class_id != $class_id) {
                    continue; // Skip subjects not belonging to the class
                }

                if ($lecturer_department_id != $department_id) {
                    // Check if the email has already been sent to this lecturer
                    if (!in_array($lecturer_email, $emailed_lecturers)) {
                        // Send email notification for cross-department allocation
                        $email_subject = "New Lesson Allocation Request";
                        $email_body = "You have been requested to teach a lesson in another department.<br>
                                       Class: $class_name<br>Subject: $subject_name<br>Start Time: $start_time<br>End Time: $end_time<br>Day: $day<br>";
                        send_email($lecturer_email, $email_subject, $email_body);

                        // Add the lecturer's email to the list to avoid sending duplicates
                        $emailed_lecturers[] = $lecturer_email;
                    }

                    continue; // Skip lecturers from other departments
                }

                if (in_array($subject_id, $allocated_subjects)) {
                    continue; // Skip already allocated subjects
                }

                // Validation 1: The same subject cannot be allocated to more than one lecturer in the same class
                $subject_allocation_query = $conn->prepare("
                    SELECT COUNT(*) FROM allocations 
                    WHERE subject_id = ? AND class_id = ?
                ");
                $subject_allocation_query->bind_param("ii", $subject_id, $class_id);
                $subject_allocation_query->execute();
                $subject_allocation_query->bind_result($subject_allocated_count);
                $subject_allocation_query->fetch();
                $subject_allocation_query->close(); // Close statement

                if ($subject_allocated_count > 0) {
                    continue; // Skip if the subject is already allocated in this class
                }

                // Validation 2: One lecturer cannot be allocated different subjects in the same class
                $lecturer_allocation_query = $conn->prepare("
                    SELECT COUNT(*) FROM allocations 
                    WHERE lecturer_id = ? AND class_id = ? AND subject_id != ?
                ");
                $lecturer_allocation_query->bind_param("iii", $lecturer_id, $class_id, $subject_id);
                $lecturer_allocation_query->execute();
                $lecturer_allocation_query->bind_result($lecturer_allocated_count);
                $lecturer_allocation_query->fetch();
                $lecturer_allocation_query->close(); // Close statement

                if ($lecturer_allocated_count > 0) {
                    continue; // Skip if the lecturer is already allocated other subjects in this class
                }

                // Validation 3: A subject can only be allocated to a lecturer with the required qualifications
                $subject_qualifications_query = $conn->prepare("
                    SELECT qualifications FROM subjects WHERE id = ?
                ");
                $subject_qualifications_query->bind_param("i", $subject_id);
                $subject_qualifications_query->execute();
                $subject_qualifications_query->bind_result($subject_qualifications);
                $subject_qualifications_query->fetch();
                $subject_qualifications_query->close(); // Close statement

                $lecturer_qualifications_query = $conn->prepare("
                    SELECT qualification FROM lecturer_qualifications WHERE lecturer_id = ?
                ");
                $lecturer_qualifications_query->bind_param("i", $lecturer_id);
                $lecturer_qualifications_query->execute();
                $lecturer_qualifications_query->bind_result($lecturer_qualifications);
                $lecturer_qualifications_query->fetch();
                $lecturer_qualifications_query->close(); // Close statement

                if (strpos($lecturer_qualifications, $subject_qualifications) === false) {
                    continue; // Skip if lecturer doesn't have the required qualifications
                }

                // Allocate the subject to the lecturer
                $allocation_query = $conn->prepare("
                    INSERT INTO allocations (class_id, subject_id, lecturer_id, start_time, end_time, duration, day_of_week)
                    VALUES (?, ?, ?, ?, ?, ?, ?)
                ");
                $allocation_query->bind_param("iiissss", $class_id, $subject_id, $lecturer_id, $start_time, $end_time, $duration, $day_of_week);
                if ($allocation_query->execute()) {
                    // Send notification
                    $notification_title = "Lesson Allocation";
                    $notification_message = "You have been allocated to teach $subject_name in $class_name.<br>Start Time: $start_time<br>End Time: $end_time<br>Day: $day<br>";
                    send_notification($conn, $notification_title, 'lecturer', $notification_message, null, $lecturer_id, $user_id);
                    $allocated_subjects[] = $subject_id; // Track allocated subjects
                    $allocated = true; // Mark allocation successful
                    $notification_sent = true;
                }
                $allocation_query->close(); // Close statement

                // Break out of the loop once a subject is allocated
                break;
            }

            // Break out of the loop if a subject has been successfully allocated
            if ($allocated) {
                break;
            }
        }

        // Break out of the loop if a subject has been successfully allocated
        if ($allocated) {
            break;
        }
    }
}

// If no notifications have been sent
if (!$notification_sent) {
    $_SESSION['info'] = "No allocations were made during this process.";
}

// If no emails have been sent
if (!$email_sent) {
    echo "No emails were sent.";
}

// Redirect to the desired page
header('Location: home.php');
exit();
?>
