<?php
// public/view_allocations.php

session_start();
require 'includes/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$lecturerId = $_SESSION['user_id'];

global $conn;
$sql = "SELECT subjects.name AS subject_name, allocations.course, allocations.level, allocations.start_time, allocations.end_time, allocations.duration 
        FROM allocations 
        JOIN subjects ON allocations.subject_id = subjects.id 
        WHERE allocations.lecturer_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $lecturerId);
$stmt->execute();
$result = $stmt->get_result();
$allocations = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Allocations</title>
</head>
<body>
    <h1>Allocated Subjects</h1>
    <table border="1">
        <tr>
            <th>Subject Name</th>
            <th>Course</th>
            <th>Level</th>
            <th>Start Time</th>
            <th>End Time</th>
            <th>Duration</th>
        </tr>
        <?php foreach ($allocations as $allocation): ?>
            <tr>
                <td><?php echo htmlspecialchars($allocation['subject_name']); ?></td>
                <td><?php echo htmlspecialchars($allocation['course']); ?></td>
                <td><?php echo htmlspecialchars($allocation['level']); ?></td>
                <td><?php echo htmlspecialchars($allocation['start_time']); ?></td>
                <td><?php echo htmlspecialchars($allocation['end_time']); ?></td>
                <td><?php echo htmlspecialchars($allocation['duration']); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
