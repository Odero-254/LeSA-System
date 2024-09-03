<?php
// Check if session is not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if ($_SESSION['user_role'] != 'HOD') {
    header('Location: login.php');
    exit();
}

require_once 'includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $lecturer_id = $_POST['lecturer_id'];
    $subject_id = $_POST['subject_id'];
    $class_id = $_POST['class_id'];
    $day = $_POST['day'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];

    // Check if lecturer is qualified for the subject
    $stmt = $con->prepare("SELECT * FROM lecturer_subjects WHERE lecturer_id = ? AND subject_id = ?");
    $stmt->bind_param("ii", $lecturer_id, $subject_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        echo "Lecturer not qualified for this subject.";
        exit();
    }

    // Check if lecturer has another lesson at the same time
    $stmt = $con->prepare("SELECT * FROM allocations WHERE lecturer_id = ? AND day = ? AND start_time = ?");
    $stmt->bind_param("iss", $lecturer_id, $day, $start_time);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        echo "Lecturer already has a lesson at this time.";
        exit();
    }

    // Allocate the lesson
    $stmt = $con->prepare("INSERT INTO allocations (lecturer_id, subject_id, class_id, day, start_time, end_time) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iiisss", $lecturer_id, $subject_id, $class_id, $day, $start_time, $end_time);
    $stmt->execute();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Allocation</title>
    <link rel="shortcut icon" href="dist/img/favicon.ico">
</head>
<body>
    <h1>Lessons Allocation</h1>
    <form method="post">
        <label>Lecturer ID:</label>
        <input type="number" name="lecturer_id" required><br>
        <label>Subject ID:</label>
        <input type="number" name="subject_id" required><br>
        <label>Class ID:</label>
        <input type="number" name="class_id" required><br>
        <label>Day:</label>
        <input type="text" name="day" required><br>
        <label>Start Time:</label>
        <input type="time" name="start_time" required><br>
        <label>End Time:</label>
        <input type="time" name="end_time" required><br>
        <input type="submit" value="Allocate Lesson">
    </form>
</body>
</html>
