<?php
// Check if session is not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require 'includes/config.php';

// Assume user details are stored in session
$user_department_id = $_SESSION['department_id'];

// Fetch classes
$query = "SELECT * FROM classes WHERE department_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $user_department_id);
$stmt->execute();
$result = $stmt->get_result();

?>
<!DOCTYPE html>
<html>
<head>
    <title>Classes</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Classes</h1>
    <div class="class-container">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="class-block">
                <a href="class_subjects.php?class_id=<?php echo $row['id']; ?>">
                    <?php echo $row['class_name']; ?>
                </a>
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html>
