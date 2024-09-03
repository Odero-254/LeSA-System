<?php
// functions/term_functions.php
require 'includes/configs.php';

function setTermDates($startDate, $endDate, $userId) {
    global $conn;
    $sql = "INSERT INTO term_dates (term_start_date, term_end_date, created_by) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $startDate, $endDate, $userId);
    $stmt->execute();
    $stmt->close();
}

function setWeeklySchedule($dayOfWeek, $lessonStart, $lessonEnd, $breakStart, $breakEnd, $userId) {
    global $conn;
    $sql = "INSERT INTO weekly_schedule (day_of_week, lesson_start_time, lesson_end_time, break_start_time, break_end_time, created_by) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $dayOfWeek, $lessonStart, $lessonEnd, $breakStart, $breakEnd, $userId);
    $stmt->execute();
    $stmt->close();
}

function setExamSchedule($examDate, $examStart, $examEnd, $userId) {
    global $conn;
    $sql = "INSERT INTO examination_schedule (exam_date, exam_start_time, exam_end_time, created_by) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $examDate, $examStart, $examEnd, $userId);
    $stmt->execute();
    $stmt->close();
}

function areTermDatesSet() {
    global $conn;
    $sql = "SELECT COUNT(*) as count FROM term_dates";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return $row['count'] > 0;
}

function allocateLesson($lessonName, $lecturerId, $scheduledDate, $startTime, $endTime) {
    if (!areTermDatesSet()) {
        throw new Exception("Term dates are not set. Lessons cannot be allocated.");
    }
    
    global $conn;
    $sql = "INSERT INTO lessons (lesson_name, lecturer_id, scheduled_date, start_time, end_time) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sisss", $lessonName, $lecturerId, $scheduledDate, $startTime, $endTime);
    $stmt->execute();
    $stmt->close();
}

function generateEndOfTermNotifications() {
    global $conn;
    $sql = "SELECT id FROM users";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $userId = $row['id'];
        $notificationText = "The term has ended. Please check your performance and attendance.";
        $sql = "INSERT INTO notifications (user_id, notification_text) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $userId, $notificationText);
        $stmt->execute();
        $stmt->close();
    }
}
?>
