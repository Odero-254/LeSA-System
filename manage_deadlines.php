<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include('includes/config.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch assignments close to deadline
$assignments_query = $conn->prepare("SELECT a.id, a.title, a.due_date, c.course_name, cl.class_name FROM assignments a
    JOIN courses c ON a.course_id = c.id 
    JOIN classes cl ON a.class_id = cl.id 
    WHERE a.due_date > NOW() AND a.due_date < DATE_ADD(NOW(), INTERVAL 2 DAY)");
$assignments_query->execute();
$assignments_result = $assignments_query->get_result();

$assignments = [];
while ($row = $assignments_result->fetch_assoc()) {
    $assignments[] = $row;
}

// Send notifications if any
if (!empty($assignments)) {
    foreach ($assignments as $assignment) {
        $message = "Assignment '{$assignment['title']}' is due on {$assignment['due_date']}.";
        $users_query = $conn->prepare("SELECT id FROM users WHERE role = 'student' AND department_id = (SELECT department_id FROM courses WHERE id = ?)");
        $users_query->bind_param('i', $assignment['course_id']);
        $users_query->execute();
        $users_result = $users_query->get_result();

        while ($user = $users_result->fetch_assoc()) {
            $notification_stmt = $conn->prepare("INSERT INTO notifications (user_id, message) VALUES (?, ?)");
            $notification_stmt->bind_param('is', $user['id'], $message);
            $notification_stmt->execute();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Deadlines</title>
</head>
<body>

<h2>Assignments Close to Deadline</h2>

<?php if (!empty($assignments)): ?>
    <ul>
        <?php foreach ($assignments as $assignment): ?>
            <li><?php echo htmlspecialchars("{$assignment['title']} (Due: {$assignment['due_date']}) - Course: {$assignment['course_name']}, Class: {$assignment['class_name']}"); ?></li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>No assignments close to the deadline.</p>
<?php endif; ?>

</body>
</html>
