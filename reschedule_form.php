<?php
session_start();
require 'includes/config.php';

// Fetch allocation ID from URL
$allocation_id = $_GET['allocation_id'];

// Fetch allocation details
$sql = "SELECT * FROM allocations WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $allocation_id);
$stmt->execute();
$allocation = $stmt->get_result()->fetch_assoc();
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_start_time = $_POST['start_time'];
    $new_day_of_week = $_POST['day_of_week'];
    $new_date = $_POST['date'];
    $reason = $_POST['reason'];

    // Automatically set new end time (2 hours after start time)
    $new_end_time = date("H:i:s", strtotime($new_start_time . ' + 2 hours'));

    // Check for conflicts
    $sql = "SELECT * FROM allocations WHERE class_id = ? AND day_of_week = ? AND start_time = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $allocation['class_id'], $new_day_of_week, $new_start_time);
    $stmt->execute();
    $conflict = $stmt->get_result()->num_rows > 0;
    $stmt->close();

    if ($conflict) {
        echo "Conflict detected. Please choose another time or day.";
    } else {
        // Insert reschedule request
        $sql = "INSERT INTO rescheduled_lessons (allocation_id, new_start_time, new_end_time, new_day_of_week, new_date, reason, requested_by, requested_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isssssi", $allocation_id, $new_start_time, $new_end_time, $new_day_of_week, $new_date, $reason, $_SESSION['user_id']);
        if ($stmt->execute()) {
            // Send notification to Class Representative
            $class_id = $allocation['class_id'];
            $sql = "SELECT id FROM users WHERE user_role = 'class_rep' AND class_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $class_id);
            $stmt->execute();
            $class_rep = $stmt->get_result()->fetch_assoc();
            $stmt->close();

            $title = "Class Attendance Tracking";
            $message = "A reschedule request has been made by Lecturer ID: {$_SESSION['user_id']} for Subject ID: {$allocation['subject_id']} on {$new_day_of_week}, {$new_date}.";
            $notification_time = date('Y-m-d H:i:s');
            $status = "unread";
            $sender_id = $_SESSION['user_id'];
            $receiver_id = $class_rep['id'];

            $sql = "INSERT INTO notifications (title, user_role, message, status, notification_time, lesson_id, user_id, sender_id) VALUES (?, 'class_rep', ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssiiii", $title, $message, $status, $notification_time, $allocation_id, $receiver_id, $sender_id);
            $stmt->execute();
            $stmt->close();

            echo "Reschedule request submitted successfully!";
        } else {
            echo "Failed to submit reschedule request.";
        }
    }
}
?>

<h2>Reschedule Class</h2>
<form method="POST">
    <label for="start_time">New Start Time:</label>
    <input type="time" name="start_time" required><br>

    <label for="day_of_week">Day of the Week:</label>
    <input type="text" name="day_of_week" required><br>

    <label for="date">New Date:</label>
    <input type="date" name="date" required><br>

    <label for="reason">Reason for Rescheduling:</label>
    <textarea name="reason" required></textarea><br>

    <input type="submit" value="Submit Request">
</form>
