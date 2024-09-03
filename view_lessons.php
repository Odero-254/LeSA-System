<?php
session_start();
require 'includes/config.php';

// Fetch logged-in user ID and role
$lecturer_id = $_SESSION['user_id'];
$user_role = $_SESSION['user_role'];

if ($user_role !== 'Lecturer') {
    echo "Access denied!";
    exit;
}

// Fetch allocations for the lecturer
$sql = "SELECT a.*, s.subject_name AS subject_name, c.class_name FROM allocations a
        JOIN subjects s ON a.subject_id = s.id
        JOIN classes c ON a.class_id = c.id
        WHERE a.lecturer_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $lecturer_id);
$stmt->execute();
$result = $stmt->get_result();

echo "<h2>My Lessons</h2>";
echo "<table border='1'>";
echo "<tr><th>Subject</th><th>Class</th><th>Start Time</th><th>End Time</th><th>Day</th><th>Status</th><th>Action</th></tr>";
while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>{$row['subject_name']}</td>";
    echo "<td>{$row['class_name']}</td>";
    echo "<td>{$row['start_time']}</td>";
    echo "<td>{$row['end_time']}</td>";
    echo "<td>{$row['day_of_week']}</td>";
    echo "<td>{$row['status']}</td>";
    echo "<td><a href='reschedule_form.php?allocation_id={$row['id']}'>Reschedule Class</a></td>";
    echo "</tr>";
}
echo "</table>";

$stmt->close();
$conn->close();
?>
