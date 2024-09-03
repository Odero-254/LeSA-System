<?php

// Check if session is not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if ($_SESSION['user_role'] != 'Principal') {
    header('Location: login.php');
    exit();
}

require_once 'includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle term dates
    if (isset($_POST['term_name']) && isset($_POST['start_date']) && isset($_POST['end_date'])) {
        $term_name = $_POST['term_name'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];

        $stmt = $conn->prepare("INSERT INTO term_dates (term_name, start_date, end_date) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $term_name, $start_date, $end_date);
        $stmt->execute();
    }

    // Handle lesson hours
    if (isset($_POST['lesson_day']) && isset($_POST['lesson_start']) && isset($_POST['lesson_end'])) {
        $lesson_day = $_POST['lesson_day'];
        $lesson_start = $_POST['lesson_start'];
        $lesson_end = $_POST['lesson_end'];

        $stmt = $conn->prepare("INSERT INTO lesson_hours (day_of_week, start_time, end_time) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $lesson_day, $lesson_start, $lesson_end);
        $stmt->execute();
    }

    // Handle break durations
    if (isset($_POST['break_day']) && isset($_POST['break_type']) && isset($_POST['break_start']) && isset($_POST['break_end'])) {
        $break_day = $_POST['break_day'];
        $break_type = $_POST['break_type'];
        $break_start = $_POST['break_start'];
        $break_end = $_POST['break_end'];

        $stmt = $conn->prepare("INSERT INTO break_durations (day_of_week, break_type, break_start, break_end) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $break_day, $break_type, $break_start, $break_end);
        $stmt->execute();
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Academic Dates</title>
</head>
<body>
    <h1>Set Term Dates</h1>
    <form method="post">
        <label>Term Name:</label>
        <input type="text" name="term_name" required><br>
        <label>Start Date:</label>
        <input type="date" name="start_date" required><br>
        <label>End Date:</label>
        <input type="date" name="end_date" required><br>
        <input type="submit" value="Set Term Dates">
    </form>

    <h1>Set Lesson Hours</h1>
    <form method="post">
        <label>Day of the Week:</label>
        <input type="text" name="lesson_day" required><br>
        <label>Lesson Start Time:</label>
        <input type="time" name="lesson_start" required><br>
        <label>Lesson End Time:</label>
        <input type="time" name="lesson_end" required><br>
        <input type="submit" value="Set Lesson Hours">
    </form>

    <h1>Set Break Durations</h1>
    <form method="post">
        <label>Day of the Week:</label>
        <input type="text" name="break_day" required><br>
        <label>Break Type (short/lunch):</label>
        <input type="text" name="break_type" required><br>
        <label>Break Start Time:</label>
        <input type="time" name="break_start" required><br>
        <label>Break End Time:</label>
        <input type="time" name="break_end" required><br>
        <input type="submit" value="Set Break Durations">
    </form>
</body>
</html>
