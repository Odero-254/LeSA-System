<?php
// Check if session is not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require 'includes/config.php';

// Ensure department_id is set in the session
if (!isset($_SESSION['department_id'])) {
    die("Error: Department ID is not set in the session.");
}

$subject_id = $_GET['subject_id'] ?? null;
$class_id = $_GET['class_id'] ?? null;
$user_department_id = $_SESSION['department_id'] ?? null;

if ($subject_id === null || $class_id === null) {
    die("Error: Subject ID or Class ID is missing.");
}

// Fetch subject details
$query = "SELECT * FROM subjects WHERE id = ?";
$stmt = $conn->prepare($query);
if (!$stmt) {
    die("Error preparing statement: " . $conn->error);
}
$stmt->bind_param('i', $subject_id);
$stmt->execute();
$subject_result = $stmt->get_result();
$subject = $subject_result->fetch_assoc();
$stmt->close();

// Fetch qualified lecturers
$query = "SELECT l.id, l.username FROM lecturers l 
          JOIN lecturer_subjects ls ON l.id = ls.lecturer_id 
          WHERE ls.subject_id = ? AND l.department_id = ?";
$stmt = $conn->prepare($query);
if (!$stmt) {
    die("Error preparing statement: " . $conn->error);
}
$stmt->bind_param('ii', $subject_id, $user_department_id);
$stmt->execute();
$lecturer_result = $stmt->get_result();
$stmt->close();

?>
<!DOCTYPE html>
<html>
<head>
    <title>Lecturers</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1><?php echo htmlspecialchars($subject['subject_name']); ?></h1>
    <div class="lecturer-container">
        <?php if ($lecturer_result->num_rows > 0): ?>
            <?php while ($row = $lecturer_result->fetch_assoc()): ?>
                <div class="lecturer-block">
                    <a href="allocate_lesson.php?lecturer_id=<?php echo $row['id']; ?>&subject_id=<?php echo $subject_id; ?>&class_id=<?php echo $class_id; ?>">
                        <?php echo htmlspecialchars($row['username']); ?>
                    </a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="alert alert-warning">
                No qualified lecturers found for this subject in your department.
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
