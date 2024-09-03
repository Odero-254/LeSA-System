<?php
// Check if session is not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require 'includes/config.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<div class="dashboard">
    <h1>Term Academic Calendar</h1>
    
    <h2 id="term-dates">Set Term Dates</h2>
    <?php include 'templates/term_form.php'; ?>
    
    <h2 id="weekly-schedule">Set Weekly Schedule</h2>
    <?php include 'templates/weekly_schedule_form.php'; ?>
    
    <h2 id="exam-schedule">Set Examination Schedule</h2>
    <?php include 'templates/exam_schedule_form.php'; ?>
</div>

