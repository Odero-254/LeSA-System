<?php
session_start();
require 'includes/config.php';

if ($_SESSION['user_role'] !== 'class_rep') {
    echo "Access denied!";
    exit;
}

// Fetch request ID and action (approve/reject)
$request_id = $_GET['id'];
$action = $_GET['action'];

if ($action === 'approve') {
    // Update reschedule status to approved
    $sql = "UPDATE rescheduled_lessons SET status = 'approved' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $request_id);
    $stmt->execute();

    // Send approval notification to lecturer
    $sql = "SELECT allocation_id, requested_by FROM rescheduled_lessons WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $request_id);
    $stmt->execute();
    $request = $stmt->get_result()->fetch_assoc();

    $allocation_id = $request['allocation_id'];
    $lecturer_id = $request['requested_by'];
    
    $title = "Class Attendance Tracking";
    $message = "Your reschedule request for Allocation ID: $allocation_id has been approved.";
    $notification_time = date('Y-m-d H:i:s');
    $status = "unread";
    $sender_id = $_SESSION['user_id'];
    
    $sql = "INSERT INTO notifications (title, user_role, message, status, notification_time, lesson_id, user_id, sender_id) VALUES (?, 'lecturer', ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssiiii", $title, $message, $status, $notification_time, $allocation_id, $lecturer_id, $sender_id);
    $stmt->execute();
    
    echo "Reschedule request approved.";
} elseif ($action === 'reject') {
    // Update reschedule status to rejected and add response message
    $response_message = $_POST['response_message'];
    $sql = "UPDATE rescheduled_lessons SET status = 'rejected', response_message = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $response_message, $request_id);
    $stmt->execute();

    // Send rejection notification to lecturer
    $sql = "SELECT allocation_id, requested_by FROM rescheduled_lessons WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $request_id);
    $stmt->execute();
    $request = $stmt->get_result()->fetch_assoc();

    $allocation_id = $request['allocation_id'];
    $lecturer_id = $request['requested_by'];
    
    $title = "Class Attendance Tracking";
    $message = "Your reschedule request for Allocation ID: $allocation_id has been rejected. Reason: $response_message";
    $notification_time = date('Y-m-d H:i:s');
    $status = "unread";
    $sender_id = $_SESSION['user_id'];
    
    $sql = "INSERT INTO notifications (title, user_role, message, status, notification_time, lesson_id, user_id, sender_id) VALUES (?, 'lecturer', ?, ?, ?, ?, ?, ?)";
    $stmt->prepare($sql);
    $stmt->bind_param("sssiiii", $title, $message, $status, $notification_time, $allocation_id, $lecturer_id, $sender_id);
    $stmt->execute();
    
    echo "Reschedule request rejected.";
} else {
    echo "Invalid action!";
}

$stmt->close();
$conn->close();
?>
