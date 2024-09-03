<?php
include 'includes/config.php';

function sendNotifications() {
    global $conn;

    $sql = "SELECT n.id, n.lesson_id, n.user_id, n.notification_time, l.lesson_name 
            FROM notifications n
            JOIN lessons l ON n.lesson_id = l.id
            WHERE n.notification_time <= NOW() AND n.is_sent = FALSE";
    $result = $conn->query($sql);

    $notificationsSent = 0;

    while ($row = $result->fetch_assoc()) {
        $userSql = "SELECT email FROM users WHERE id = ?";
        $userStmt = $conn->prepare($userSql);
        $userStmt->bind_param("i", $row['user_id']);
        $userStmt->execute();
        $userResult = $userStmt->get_result();
        $userRow = $userResult->fetch_assoc();
        $userEmail = $userRow['email'];
        
        sendEmail($userEmail, "Lesson Reminder", "Reminder: You have a lesson ({$row['lesson_name']}) in 1 hour.");
        
        $updateSql = "UPDATE notifications SET is_sent = TRUE WHERE id = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("i", $row['id']);
        $updateStmt->execute();
        
        $userStmt->close();
        $updateStmt->close();

        $notificationsSent++;
    }

    return ['status' => 'success', 'message' => "$notificationsSent notifications sent."];
}

function sendEmail($to, $subject, $message) {
    // Implement email sending logic here (e.g., using PHPMailer)
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $response = sendNotifications();
    header('Content-Type: application/json');
    echo json_encode($response);
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Notifications</title>
</head>
<body>
    <h1>Send Notifications</h1>
    <button id="sendNotificationsBtn">Send Notifications</button>

    <script>
    document.getElementById('sendNotificationsBtn').addEventListener('click', function() {
        fetch('/path/to/send_notifications.php', {
            method: 'POST'
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
        })
        .catch(error => console.error('Error:', error));
    });
    </script>
</body>
</html>
