<?php
// Check if session is not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require 'includes/config.php';

// Assuming the logged-in user's ID is stored in the session
$sender_id = $_SESSION['user_id'];

// Check if the AJAX request is received
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the recipient and message from the POST request
    $recipient_id = $_POST['recipient'];
    $message_content = $_POST['message'];

    // Validate input
    if (empty($recipient_id) || empty($message_content)) {
        echo "Recipient and message cannot be empty.";
        exit;
    }

    // Prepare and execute the SQL statement
    $sql = "INSERT INTO messages (sender_id, recipient_id, message, timestamp, status) VALUES (?, ?, ?, NOW(), 'sent')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('iis', $sender_id, $recipient_id, $message_content);

    if ($stmt->execute()) {
        echo "Message sent successfully!";
    } else {
        echo "Error sending message: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
?>
