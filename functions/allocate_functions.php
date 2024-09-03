<?php
// functions/allocate_functions.php

require 'includes/config.php';

function getQualifiedLecturers($subjectId) {
    global $conn;
    $sql = "SELECT id, name FROM lecturers WHERE FIND_IN_SET(?, qualified_subjects)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $subjectId);
    $stmt->execute();
    $result = $stmt->get_result();
    $lecturers = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $lecturers;
}

function isLecturerAllocated($lecturerId, $subjectId, $course, $level) {
    global $conn;
    $sql = "SELECT COUNT(*) FROM allocations WHERE lecturer_id = ? AND subject_id = ? AND course = ? AND level = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiis", $lecturerId, $subjectId, $course, $level);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    return $count > 0;
}

function getNextAvailableLecturer($subjectId, $course, $level) {
    $lecturers = getQualifiedLecturers($subjectId);
    foreach ($lecturers as $lecturer) {
        if (!isLecturerAllocated($lecturer['id'], $subjectId, $course, $level)) {
            return $lecturer;
        }
    }
    return null;
}
