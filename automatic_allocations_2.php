<?php
// includes/config.php
include 'includes/config.php';

// Start session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$department_id = $_SESSION['department_id']; // Assuming department_id is stored in the session

// Check if there is an active term
$active_term_query = "SELECT * FROM term_dates WHERE status = 'running' LIMIT 1";
$active_term_result = mysqli_query($conn, $active_term_query);

if (mysqli_num_rows($active_term_result) == 0) {
    echo "<script>alert('No active term found. Please set the term dates first.');</script>";
    exit;
}

$term = mysqli_fetch_assoc($active_term_result);
$term_start_date = $term['start_date'];
$term_end_date = $term['end_date'];

// Fetch classes from the same department as the logged-in user
$classes_query = "SELECT * FROM classes WHERE department_id = '$department_id'";
$classes_result = mysqli_query($conn, $classes_query);

if (mysqli_num_rows($classes_result) == 0) {
    echo "<script>alert('No classes found for your department.');</script>";
    exit;
}

// Fetch lecturers from the same department as the logged-in user
$lecturers_query = "SELECT * FROM lecturers WHERE department_id = '$department_id'";
$lecturers_result = mysqli_query($conn, $lecturers_query);

if (mysqli_num_rows($lecturers_result) == 0) {
    echo "<script>alert('No lecturers found for your department.');</script>";
    exit;
}

// Fetch subjects from the same department as the logged-in user
$subjects_query = "SELECT * FROM subjects WHERE department_id = '$department_id'";
$subjects_result = mysqli_query($conn, $subjects_query);

if (mysqli_num_rows($subjects_result) == 0) {
    echo "<script>alert('No subjects found for your department.');</script>";
    exit;
}

$allocations_done = []; // To keep track of completed allocations
$conflicts = []; // To store conflicts

// Loop through each class
while ($class = mysqli_fetch_assoc($classes_result)) {
    $class_id = $class['id'];
    $class_name = $class['class_name'];
    $course_id = $class['course_id'];
    $level_id = $class['level_id'];

    // Fetch subjects for the class
    $class_subjects_query = "SELECT * FROM subjects WHERE class_id = '$class_id'";
    $class_subjects_result = mysqli_query($conn, $class_subjects_query);

    // Loop through each subject
    while ($subject = mysqli_fetch_assoc($class_subjects_result)) {
        $subject_id = $subject['id'];
        $subject_name = $subject['subject_name'];

        // Fetch lecturers who qualify to teach this subject
        $qualified_lecturers_query = "
            SELECT lecturers.*, users.email 
            FROM lecturers 
            JOIN lecturer_subjects ON lecturers.id = lecturer_subjects.lecturer_id
            JOIN users ON lecturers.user_id = users.id
            WHERE lecturer_subjects.subject_id = '$subject_id' 
            AND lecturers.department_id = '$department_id'
        ";
        $qualified_lecturers_result = mysqli_query($conn, $qualified_lecturers_query);

        if (mysqli_num_rows($qualified_lecturers_result) == 0) {
            $conflicts[] = "No qualified lecturers found for $subject_name in class $class_name.";
            continue;
        }

        // Loop through each lecturer
        while ($lecturer = mysqli_fetch_assoc($qualified_lecturers_result)) {
            $lecturer_id = $lecturer['id'];
            $lecturer_name = $lecturer['username'];
            $lecturer_email = $lecturer['email'];

            // Check if this allocation already exists
            $allocation_check_query = "
                SELECT * FROM allocations 
                WHERE lecturer_id = '$lecturer_id' 
                AND subject_id = '$subject_id' 
                AND class_id = '$class_id'
            ";
            $allocation_check_result = mysqli_query($conn, $allocation_check_query);

            if (mysqli_num_rows($allocation_check_result) > 0) {
                $conflicts[] = "This allocation already exists for $lecturer_name teaching $subject_name in $class_name.";
                continue;
            }

            // Randomize allocation times
            $timeslots = [
                ['start_time' => '08:00:00', 'end_time' => '10:00:00', 'duration' => '2 hours'],
                ['start_time' => '10:15:00', 'end_time' => '12:15:00', 'duration' => '2 hours'],
                ['start_time' => '13:15:00', 'end_time' => '15:15:00', 'duration' => '2 hours'],
                ['start_time' => '15:30:00', 'end_time' => '17:30:00', 'duration' => '2 hours']
            ];

            foreach ($timeslots as $day => $slot) {
                $day_of_week = $day + 1; // 1 = Monday, 2 = Tuesday, etc.
                $start_time = $slot['start_time'];
                $end_time = $slot['end_time'];
                $duration = $slot['duration'];

                // Perform checks
                $time_conflict_check_query = "
                    SELECT * FROM allocations 
                    WHERE class_id = '$class_id' 
                    AND day_of_week = '$day_of_week' 
                    AND (
                        (start_time <= '$start_time' AND end_time > '$start_time') OR 
                        (start_time < '$end_time' AND end_time >= '$end_time')
                    )
                ";
                $time_conflict_check_result = mysqli_query($conn, $time_conflict_check_query);

                if (mysqli_num_rows($time_conflict_check_result) > 0) {
                    $conflicts[] = "Time conflict detected for $lecturer_name teaching $subject_name in $class_name on day $day_of_week.";
                    continue;
                }

                // Check if the lecturer is already allocated during this time slot on the same day
                $allocation_time_conflict_query = "
                SELECT * FROM allocations 
                WHERE lecturer_id = '$lecturer_id' 
                AND day_of_week = '$day_of_week' 
                AND (
                    (start_time <= '$start_time' AND end_time > '$start_time') OR 
                    (start_time < '$end_time' AND end_time >= '$end_time')
                )
                ";
                $allocation_time_conflict_result = mysqli_query($conn, $allocation_time_conflict_query);

                if (mysqli_num_rows($allocation_time_conflict_result) == 0) {
                // No conflict, proceed with insertion
                $insert_allocation_query = "
                    INSERT INTO allocations (lecturer_id, subject_id, class_id, course, level, start_time, end_time, duration, day_of_week)
                    VALUES ('$lecturer_id', '$subject_id', '$class_id', '$course_id', '$level_id', '$start_time', '$end_time', '$duration', '$day_of_week')
                ";

                if (mysqli_query($conn, $insert_allocation_query)) {
                    // Add allocation details to array for email and notification
                    $allocations_done[] = [
                        'lecturer_id' => $lecturer_id,
                        'lecturer_name' => $lecturer_name,
                        'lecturer_email' => $lecturer_email,
                        'class_name' => $class_name,
                        'subject_name' => $subject_name,
                        'start_time' => $start_time,
                        'end_time' => $end_time,
                        'day_of_week' => $day_of_week,
                        'duration' => $duration
                    ];
                } else {
                    $conflicts[] = "Failed to allocate $lecturer_name to $subject_name in $class_name.";
                }
                } else {
                $conflicts[] = "Conflict detected: $lecturer_name is already allocated during $start_time to $end_time on day $day_of_week.";
                }

            }
        }
    }
}

// Include PHPMailer for email notifications

require 'vendor/autoload.php'; // Include PHPMailer autoload file

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor\phpmailer\phpmailer\src\Exception.php';
require 'vendor\phpmailer\phpmailer\src\PHPMailer.php';
require 'vendor\phpmailer\phpmailer\src\SMTP.php';

// Send email and notifications
foreach ($allocations_done as $allocation) {
    $lecturer_id = $allocation['lecturer_id'];
    $lecturer_email = $allocation['lecturer_email'];
    $message = "You have been allocated the following lesson:\nClass: " . $allocation['class_name'] . "\nSubject: " . $allocation['subject_name'] . "\nTime: " . $allocation['start_time'] . " to " . $allocation['end_time'] . "\nDay: " . $allocation['day_of_week'];

    // Send email
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.google.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'benardodero21@gmail.com';
        $mail->Password = 'nfzm oxyi jstv auxp';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('benardodero21@gmail.com', 'Lesson Allocation');
        $mail->addAddress($lecturer_email);

        $mail->isHTML(true);
        $mail->Subject = 'Lesson Allocation';
        $mail->Body    = nl2br($message);

        $mail->send();
    } catch (Exception $e) {
        $conflicts[] = "Mailer Error: {$mail->ErrorInfo}";
    }

    // Insert notification into the database
    $notification_query = "
        INSERT INTO notifications (user_id, message, date_sent, status)
        VALUES ('$lecturer_id', '$message', NOW(), 'unread')
    ";
    mysqli_query($conn, $notification_query);
}

// Generate PDF Report
require('vendor\setasign\fpdf\fpdf.php');

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Lesson Allocations Report', 0, 1, 'C');

$pdf->SetFont('Arial', '', 10);
foreach ($allocations_done as $allocation) {
    $pdf->Cell(0, 10, 'Lecturer: ' . $allocation['lecturer_name'], 0, 1);
    $pdf->Cell(0, 10, 'Class: ' . $allocation['class_name'], 0, 1);
    $pdf->Cell(0, 10, 'Subject: ' . $allocation['subject_name'], 0, 1);
    $pdf->Cell(0, 10, 'Time: ' . $allocation['start_time'] . ' to ' . $allocation['end_time'], 0, 1);
    $pdf->Cell(0, 10, 'Day: ' . $allocation['day_of_week'], 0, 1);
    $pdf->Ln(5);
}

if (!empty($conflicts)) {
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'Conflicts', 0, 1, 'C');

    $pdf->SetFont('Arial', '', 10);
    foreach ($conflicts as $conflict) {
        $pdf->Cell(0, 10, $conflict, 0, 1);
    }
}

// Output the PDF as a file
$pdf_output_path = 'allocations_report.pdf';
$pdf->Output('F', $pdf_output_path);

echo "<script>alert('Allocation process complete. Please download the report.');</script>";
echo "<a href='$pdf_output_path' download>Download Allocation Report</a>";

?>
