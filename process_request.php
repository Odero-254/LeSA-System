<?php
// Check if session is not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require 'includes/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $department = $_POST['department'] ?? '';

    // Validate input
    if (empty($name) || empty($phone) || empty($department)) {
        $_SESSION['alertMessage'] = 'All fields are required.';
        $_SESSION['alertType'] = 'danger';
        header('Location: request_account.php');
        exit();
    }

    // Insert request into the database
    $sql = "INSERT INTO account_requests (name, phone, department, status) VALUES (?, ?, ?, 'Pending')";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        $_SESSION['alertMessage'] = 'Prepare failed: ' . htmlspecialchars($conn->error);
        $_SESSION['alertType'] = 'danger';
        header('Location: request_account.php');
        exit();
    }

    $stmt->bind_param("sss", $name, $phone, $department);

    if (!$stmt->execute()) {
        $_SESSION['alertMessage'] = 'Execute failed: ' . htmlspecialchars($stmt->error);
        $_SESSION['alertType'] = 'danger';
        header('Location: request_account.php');
        exit();
    }

    $request_id = $stmt->insert_id;
    $stmt->close();

    // Define roles for notification
    $roles = ['Principal', 'Deputy Principal'];

    // Create approval and rejection links
    $approve_link = "add_user.php?request_id=$request_id&status=approved";
    $reject_link = "reject_request.php?request_id=$request_id&status=rejected";

    // Prepare notification message
    $notification_message = "New account request from $name in $department department.";

    // Insert notifications into the database
    $notification_sql = "INSERT INTO notifications (title, user_role, message, status, notification_time, lesson_id, user_id, is_sent, link) 
                         VALUES (?, ?, ?, 'unread', NOW(), 0, 0, 0, ?), 
                                (?, ?, ?, 'unread', NOW(), 0, 0, 0, ?)";

    $notification_stmt = $conn->prepare($notification_sql);

    if ($notification_stmt === false) {
        $_SESSION['alertMessage'] = 'Prepare failed: ' . htmlspecialchars($conn->error);
        $_SESSION['alertType'] = 'danger';
        header('Location: request_account.php');
        exit();
    }

    // Assign parameters to variables
    $title1 = 'Account request';
    $role1 = $roles[0];
    $message1 = $notification_message;
    $link1 = $approve_link;

    $title2 = 'Account request';
    $role2 = $roles[1];
    $message2 = $notification_message;
    $link2 = $reject_link;

    // Bind parameters for both notifications
    $notification_stmt->bind_param(
        "ssssssss",
        $title1, $role1, $message1, $link1,
        $title2, $role2, $message2, $link2
    );

    if (!$notification_stmt->execute()) {
        $_SESSION['alertMessage'] = 'Execute failed: ' . htmlspecialchars($notification_stmt->error);
        $_SESSION['alertType'] = 'danger';
        header('Location: request_account.php');
        exit();
    }

    $notification_stmt->close();

    $_SESSION['alertMessage'] = 'Your account request has been submitted successfully. Kindly wait for further updates.';
    $_SESSION['alertType'] = 'success';
    header('Location: request_account.php');
    exit();
} else {
    header("Location: index.html");
    exit();
}
?>
