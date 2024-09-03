<?php
// public/set_exam_schedule.php
require '../functions/term_functions.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $examDate = $_POST['exam_date'];
    $examStart = $_POST['exam_start'];
    $examEnd = $_POST['exam_end'];
    $userId = $_SESSION['user_id'];

    setExamSchedule($examDate, $examStart, $examEnd, $userId);
    echo "Examination schedule set successfully.";
}
?>
