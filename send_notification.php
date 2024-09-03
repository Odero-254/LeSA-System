<?php
// Check if session is not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require 'includes/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $subject_id = $_POST['subject_id'];
    $class_id = $_POST['class_id'];
    $course = $_POST['course'];
    $level = $_POST['level'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $day_of_week = $_POST['day_of_week'];
    $user_id = $_SESSION['user_id'];

    // Fetch a lecturer from another department who can teach the subject
    $query = "SELECT l.id, l.name, l.department_id FROM lecturers l 
              JOIN lecturer_subjects ls ON l.id = ls.lecturer_id 
              WHERE ls.subject_id = ? AND l.department_id != ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ii', $subject_id, $_SESSION['department_id']);
    $stmt->execute();
    $lecturer_result = $stmt->get_result();
    $lecturer = $lecturer_result->fetch_assoc();

    if ($lecturer) {
        // Fetch HOD of the lecturer's department
        $query = "SELECT id, email FROM users WHERE user_role = 'HOD' AND department_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $lecturer['department_id']);
        $stmt->execute();
        $hod_result = $stmt->get_result();
        $hod = $hod_result->fetch_assoc();

        if ($hod) {
            // Send notification to HOD
            $message = "Request for allocation: Subject - " . $subject_id . ", Start Time - " . $start_time . ", End Time - " . $end_time . ", Day - " . $day_of_week;
            $query = "INSERT INTO notifications (user_role, message, status, notification_time, lesson_id, user_id, is_sent) 
                      VALUES ('HOD', ?, 'Pending', NOW(), NULL, ?, 0)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('si', $message, $hod['id']);
            if ($stmt->execute()) {
                // Send email to HOD
                $to = $hod['email'];
                $subject = "Lesson Allocation Request";
                $body = $message;
                $headers = "From: benardodero21@gmail.com.com";

                if (mail($to, $subject, $body, $headers)) {
                    echo "Notification and email sent to HOD.";
                } else {
                    echo "Notification sent, but failed to send email.";
                }
            } else {
                echo "Failed to send notification.";
            }
        } else {
            echo "HOD not found.";
        }
    } else {
        echo "No lecturer found in other departments.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Send Notification</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Send Notification</h1>
    <form method="POST" action="send_notification.php">
        <input type="hidden" name="subject_id" value="<?php echo $_GET['subject_id']; ?>">
        <input type="hidden" name="class_id" value="<?php echo $_GET['class_id']; ?>">
        <div>
            <label for="course">Course:</label>
            <input type="text" name="course" id="course" required>
        </div>
        <div>
            <label for="level">Level:</label>
            <input type="text" name="level" id="level" required>
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
        <button type="submit">Send Notification</button>
    </form>
</body>
</html>
