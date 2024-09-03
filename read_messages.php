<?php
// Check if session is not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    die('User not logged in.');
}

require 'db_connection.php'; // Connect to your database

$user_id = $_SESSION['user_id'];

// Fetch user details including user_role
$stmt = $conn->prepare("SELECT user_role FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($user_role);
$stmt->fetch();
$stmt->close();

// Display messages based on user_role
$stmt = $conn->prepare("SELECT m.id, m.sender_id, u.username AS sender_name, m.message, m.timestamp 
                       FROM messages m 
                       JOIN users u ON m.sender_id = u.id 
                       WHERE m.recipient_id = ? 
                       ORDER BY m.timestamp DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($message_id, $sender_id, $sender_name, $message_content, $message_timestamp);

echo "<h2>Messages</h2>";
echo "<ul>";
while ($stmt->fetch()) {
    echo "<li>";
    echo "<strong>From:</strong> $sender_name ($user_role)<br>";
    echo "<strong>Message:</strong> $message_content<br>";
    echo "<strong>Sent:</strong> $message_timestamp<br>";
    echo "</li>";
}
echo "</ul>";

$stmt->close();
$conn->close();
?>
