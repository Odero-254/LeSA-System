<?php
// Check if session is not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];

    $sql = "UPDATE notifications SET status = 'read' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if (!$stmt->execute()) {
        die('Execute failed: ' . htmlspecialchars($stmt->error));
    }

    $stmt->close();
    $conn->close();
}
?>
