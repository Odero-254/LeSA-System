<?php
// Check if session is not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include 'includes/config.php';

// Function to send notification
function sendNotification($conn, $lecturer_user_id, $user_id) {
    $notification_query = $conn->prepare("
        INSERT INTO notifications 
        (title, user_role, message, link, status, notification_time, user_id, sender_id, is_sent)
        VALUES 
        ('Lecturer Request', 'Lecturer', 'You have been requested to teach in another department.', '', 'Unread', NOW(), ?, ?, 1)
    ");
    $notification_query->bind_param("ii", $lecturer_user_id, $user_id);
    $notification_query->execute();
}

// Handle AJAX request for requesting a lecturer
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the lecturer ID from the POST request
    $lecturer_id = intval($_POST['lecturer_id']);
    $user_id = $_SESSION['user_id']; // ID of the user making the request

    // Fetch the logged-in user's department details
    $user_department_query = $conn->prepare("SELECT department_id FROM users WHERE id = ?");
    $user_department_query->bind_param("i", $user_id);
    $user_department_query->execute();
    $user_department_query->bind_result($department_id);
    $user_department_query->fetch();
    $user_department_query->close();

    // Fetch the lecturer's department details
    $lecturer_query = $conn->prepare("SELECT department_id, user_id FROM lecturers WHERE id = ?");
    $lecturer_query->bind_param("i", $lecturer_id);
    $lecturer_query->execute();
    $lecturer_query->bind_result($lecturer_department_id, $lecturer_user_id);
    $lecturer_query->fetch();
    $lecturer_query->close();

    // Check if the lecturer belongs to a different department
    if ($department_id !== $lecturer_department_id) {
        // Insert the request into the lecturer_requests table
        $request_query = $conn->prepare("
            INSERT INTO lecturer_requests (lecturer_id, from_department_id, to_department_id, request_date, status)
            VALUES (?, ?, ?, NOW(), 'Pending')
        ");
        $request_query->bind_param("iii", $lecturer_id, $department_id, $lecturer_department_id);
        if ($request_query->execute()) {
            // Send notification to the lecturer being requested
            sendNotification($conn, $lecturer_user_id, $user_id);
            // Return a success message
            echo "Lecturer request sent successfully.";
        } else {
            // Return an error message
            echo "Failed to send lecturer request.";
        }
    } else {
        echo "Cannot request a lecturer from the same department.";
    }
    exit; // Exit after processing POST request
}

// Fetch qualified lecturers based on the logged-in user's department
$user_id = $_SESSION['user_id'];
$user_department_query = $conn->prepare("SELECT department_id FROM users WHERE id = ?");
$user_department_query->bind_param("i", $user_id);
$user_department_query->execute();
$user_department_query->bind_result($department_id);
$user_department_query->fetch();
$user_department_query->close();

// Fetch qualified lecturers from other departments
$lecturers_query = $conn->prepare("
    SELECT id, username, user_id FROM lecturers 
    WHERE department_id != ? 
");
$lecturers_query->bind_param("i", $department_id);
$lecturers_query->execute();
$lecturers_query->bind_result($lecturer_id, $lecturer_name, $lecturer_user_id);

$lecturers = [];
while ($lecturers_query->fetch()) {
    $lecturers[] = [
        'id' => $lecturer_id,
        'name' => $lecturer_name,
        'user_id' => $lecturer_user_id,
    ];
}
$lecturers_query->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Lecturer</title>
    <script>
        function requestLecturer(lecturerId) {
            // Confirmation dialog
            if (confirm("Are you sure you want to request this lecturer?")) {
                // Send AJAX request
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "request_lecturer.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function () {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        alert(xhr.responseText); // Response from the server
                    }
                };
                xhr.send("lecturer_id=" + lecturerId);
            }
        }
    </script>
</head>
<body>
    <h1>Request a Lecturer</h1>
    
    <?php if (count($lecturers) > 0): ?>
        <?php foreach ($lecturers as $lecturer): ?>
            <button onclick="requestLecturer(<?php echo $lecturer['id']; ?>)">
                Request <?php echo htmlspecialchars($lecturer['name']); ?>
            </button>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No qualified lecturers available for request.</p>
    <?php endif; ?>
    
</body>
</html>
