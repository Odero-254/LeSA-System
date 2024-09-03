<?php
// public/set_weekly_schedule.php
require '../functions/term_functions.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dayOfWeek = $_POST['day_of_week'];
    $lessonStart = $_POST['lesson_start'];
    $lessonEnd = $_POST['lesson_end'];
    $breakStart = $_POST['break_start'];
    $breakEnd = $_POST['break_end'];
    $userId = $_SESSION['user_id'];

    setWeeklySchedule($dayOfWeek, $lessonStart, $lessonEnd, $breakStart, $breakEnd, $userId);
    echo "Weekly schedule set successfully.";
}
?>
