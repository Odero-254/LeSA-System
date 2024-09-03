<?php
// Check if session is not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include 'includes/config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

// Error handling
set_error_handler(function($errno, $errstr, $errfile, $errline) {
    error_log("Error: [$errno] $errstr - $errfile:$errline");
    echo "<p style='color:red;'>An unexpected error occurred. Please try again later.</p>";
    die();
});

// Step 1: Check for active term
$user_id = $_SESSION['user_id'];
$term_query = $conn->query("SELECT start_date, end_date FROM term_dates WHERE status = 'running'");
if ($term_query->num_rows === 0) {
    echo "<script>alert('No active term found. Please set an active term before proceeding.');</script>";
    echo "<script>document.querySelector('.spinner-overlay').style.display = 'none';</script>";
    die();
}
$term = $term_query->fetch_assoc();
$start_date = $term['start_date'];
$end_date = $term['end_date'];

// Step 2: Fetch classes in the user's department
$class_query = $conn->prepare("SELECT id, class_name, course_id, level_id, department_id FROM classes WHERE department_id = (SELECT department_id FROM users WHERE id = ?)");
$class_query->bind_param("i", $user_id);
$class_query->execute();
$class_result = $class_query->get_result();

$allocated_classes = [];
$unallocated_classes = [];
$lecturer_allocations = []; // To hold consolidated notifications and emails

while ($class = $class_result->fetch_assoc()) {
    $class_id = $class['id'];
    $class_name = $class['class_name'];
    $course_id = $class['course_id'];
    $level_id = $class['level_id'];
    $department_id = $class['department_id'];

    // Step 3: Fetch qualified lecturers for the class's subjects
    $subject_query = $conn->prepare("
        SELECT s.id as subject_id, s.subject_name as subject_name
        FROM subjects s
        WHERE s.department_id = ?"
    );
    $subject_query->bind_param("i", $department_id);
    $subject_query->execute();
    $subject_result = $subject_query->get_result();

    // Shuffle the days of the week and time slots for random allocation
    $days_of_week = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
    shuffle($days_of_week);
    $time_slots = [
        ['08:00:00', '10:00:00'],
        ['10:15:00', '12:15:00'],
        ['13:15:00', '15:15:00'],
        ['15:30:00', '17:30:00']
    ];
    shuffle($time_slots);

    while ($subject = $subject_result->fetch_assoc()) {
        $subject_id = $subject['subject_id'];
        $subject_name = $subject['subject_name'];

        // Step 3a: Check if the subject has already been allocated to another lecturer for the same class
        $existing_allocation_query = $conn->prepare("
            SELECT * FROM allocations 
            WHERE class_id = ? AND subject_id = ?"
        );
        $existing_allocation_query->bind_param("ii", $class_id, $subject_id);
        $existing_allocation_query->execute();
        $existing_allocation_result = $existing_allocation_query->get_result();

        if ($existing_allocation_result->num_rows > 0) {
            continue; // Skip allocation if the subject is already allocated
        }

        $lecturer_query = $conn->prepare("
            SELECT l.id as lecturer_id, l.username
            FROM lecturers l
            INNER JOIN lecturer_subjects ls ON l.id = ls.lecturer_id
            INNER JOIN lecturer_qualifications lq ON l.id = lq.lecturer_id
            WHERE ls.subject_id = ? AND l.department_id = ?"
        );
        $lecturer_query->bind_param("ii", $subject_id, $department_id);
        $lecturer_query->execute();
        $lecturer_result = $lecturer_query->get_result();

        if ($lecturer_result->num_rows === 0) {
            $unallocated_classes[] = $class_name;
            continue;
        }

        $allocated = false;
        foreach ($days_of_week as $day) {
            // Skip Wednesday from 3:30 pm to 5:30 pm
            if ($day === 'Wednesday' && $time_slots[3] === ['15:30:00', '17:30:00']) {
                continue;
            }

            foreach ($time_slots as $slot) {
                $start_time = $slot[0];
                $end_time = $slot[1];
                $duration = '02:00:00';

                $lecturer = $lecturer_result->fetch_assoc();
                $lecturer_id = $lecturer['lecturer_id'];
                $lecturer_name = $lecturer['username'];

                // Conflict checks
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
                        VALUES (?, ?, ?, (SELECT course_name FROM courses WHERE id = ?), (SELECT name FROM levels WHERE id = ?), ?, ?, ?, ?)
                    ");
                    $allocation_query->bind_param("iiiisssss", 
                        $lecturer_id, $subject_id, $class_id, $course_id, $level_id, 
                        $start_time, $end_time, $duration, $day
                    );
                    if ($allocation_query->execute()) {
                        $allocated = true;
                        $lecturer_allocations[$lecturer_id][] = [
                            'class_name' => $class_name,
                            'subject_name' => $subject_name,
                            'start_time' => $start_time,
                            'end_time' => $end_time,
                            'duration' => $duration,
                            'day' => $day
                        ];
                        break 2; // Exit both loops if successfully allocated
                    }
                }
            }
        }

        if ($allocated) {
            $allocated_classes[] = $class_name;
        } else {
            $unallocated_classes[] = $class_name;
        }
    }
}

// Step 5: Send consolidated notifications and emails to lecturers
foreach ($lecturer_allocations as $lecturer_id => $allocations) {
    $lecturer_emails = [];
    $lecturer_query = $conn->prepare("
        SELECT u.email
        FROM users u
        INNER JOIN lecturers l ON u.id = l.user_id
        WHERE l.id = ?"
    );
    $lecturer_query->bind_param("i", $lecturer_id);
    $lecturer_query->execute();
    $lecturer_result = $lecturer_query->get_result();
    while ($lecturer = $lecturer_result->fetch_assoc()) {
        $lecturer_emails[] = $lecturer['email'];
    }

    // Build the email and notification message
    $email_body = "You have been allocated the following lessons:<br><br>";
    $notification_body = "You have been allocated the following lessons:<br><br>";
    foreach ($allocations as $allocation) {
        $email_body .= "Class: {$allocation['class_name']}<br>Subject: {$allocation['subject_name']}<br>Time: {$allocation['start_time']} - {$allocation['end_time']} ({$allocation['duration']})<br>Day: {$allocation['day']}<br><br>";
        $notification_body .= "Class: {$allocation['class_name']}<br>Subject: {$allocation['subject_name']}<br>Time: {$allocation['start_time']} - {$allocation['end_time']} ({$allocation['duration']})<br>Day: {$allocation['day']}<br><br>";
    }

    // Send email using PHPMailer
    $mail = new PHPMailer(true);
    try {
        $mail->setFrom('benardodero21@gmail.com', 'NYSEI LeSA Admin');
        $mail->addAddress($lecturer_emails[0]); // Send to the first email in the list
        $mail->isHTML(true);
        $mail->Subject = 'Lesson Allocation';
        $mail->Body = $email_body;
        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

    // Insert into notifications table
    $notification_query = $conn->prepare("
        INSERT INTO notifications (user_id, message, status)
        VALUES (?, ?, 'unread')"
    );
    $notification_query->bind_param("is", $lecturer_id, $notification_body);
    $notification_query->execute();
}

// Step 6: Alert summary of allocated and unallocated classes
$allocated_count = count($allocated_classes);
$unallocated_count = count($unallocated_classes);

echo "<script>alert('Allocation completed. Allocated classes: $allocated_count. Unallocated classes: $unallocated_count.');</script>";

// Log out user if there are no allocations left
if ($unallocated_count === 0) {
    header("Location: logout.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Allocation in Progress</title>
    <style>
        .spinner-overlay {
            display: none; /* Hide spinner initially */
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 9999;
            text-align: center;
            align-items: center;
            justify-content: center;
        }
        .spinner {
            border: 16px solid #f3f3f3; /* Light grey */
            border-top: 16px solid #3498db; /* Blue */
            border-radius: 50%;
            width: 120px;
            height: 120px;
            animation: spin 2s linear infinite;
            margin-top: 20%;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>

<div class="spinner-overlay">
    <div class="spinner"></div>
    <h2 style="color: white;">Allocating lessons, please wait...</h2>
</div>

<script>
    // Display the spinner when the page is loading
    document.querySelector('.spinner-overlay').style.display = 'flex';


    // Hide the spinner after PHP script finishes
    document.querySelector('.spinner-overlay').style.display = 'none';
   // Display the spinner
   document.querySelector('.spinner-overlay').style.display = 'flex';

// Once the page loads, execute the allocation script
window.onload = function() {
    // The PHP script will automatically run on page load
    // No need to write additional JavaScript unless you want to interact with the user
};
</script>

</body>
</html>

<?php
// Close the connection if it's still open
$conn->close();
?>