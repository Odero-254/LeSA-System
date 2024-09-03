<?php
// public/allocate_lecturer.php

session_start();
require 'includes/config.php';
require '../functions/allocate_functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $subjectId = $_POST['subject_id'];
    $course = $_POST['course'];
    $level = $_POST['level'];
    $startTime = $_POST['start_time'];
    $endTime = $_POST['end_time'];
    $duration = $_POST['duration'];
    
    $lecturer = getNextAvailableLecturer($subjectId, $course, $level);

    if ($lecturer) {
        global $conn;
        $sql = "INSERT INTO allocations (lecturer_id, subject_id, course, level, start_time, end_time, duration) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiissss", $lecturer['id'], $subjectId, $course, $level, $startTime, $endTime, $duration);
        $stmt->execute();
        $stmt->close();
        echo "Lecturer allocated successfully.";
    } else {
        echo "No available lecturers found for this subject.";
    }
}
