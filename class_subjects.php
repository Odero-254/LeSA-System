<?php
// Check if session is not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require 'includes/config.php';

$class_id = $_GET['class_id'];

// Fetch class details
$query = "SELECT * FROM classes WHERE id = ?";
$stmt = $conn->prepare($query);
if (!$stmt) {
    die("Error preparing statement: " . $conn->error);
}
$stmt->bind_param('i', $class_id);
$stmt->execute();
$class_result = $stmt->get_result();
$class = $class_result->fetch_assoc();
$stmt->close();

// Fetch subjects for the class
$query = "SELECT * FROM subjects WHERE class_id = ?";
$stmt = $conn->prepare($query);
if (!$stmt) {
    die("Error preparing statement: " . $conn->error);
}
$stmt->bind_param('i', $class_id);
$stmt->execute();
$subject_result = $stmt->get_result();
$stmt->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Subjects</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1><?php echo htmlspecialchars($class['class_name']); ?></h1>
    <div class="subject-container">
        <?php if ($subject_result->num_rows > 0): ?>
            <?php while ($row = $subject_result->fetch_assoc()): ?>
                <div class="subject-block">
                    <a href="subject_lecturers.php?subject_id=<?php echo $row['id']; ?>&class_id=<?php echo $class_id; ?>">
                        <?php echo htmlspecialchars($row['subject_name']); ?>
                    </a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="alert alert-warning">
                No subjects are allocated for this class.
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
