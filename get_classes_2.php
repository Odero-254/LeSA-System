<?php
require_once 'includes/config.php';

$department_id = $_GET['department_id'] ?? '';
$classes = [];

if ($department_id) {
    $stmt = $conn->prepare("SELECT id, class_name FROM classes WHERE department_id = ?");
    $stmt->bind_param("i", $department_id);
    $stmt->execute();
    $classes = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
}

echo json_encode($classes);
?>
