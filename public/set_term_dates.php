<?php
// public/set_term_dates.php
require '../functions/term_functions.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $startDate = $_POST['start_date'];
    $endDate = $_POST['end_date'];
    $userId = $_SESSION['user_id'];

    setTermDates($startDate, $endDate, $userId);
    echo "Term dates set successfully.";
}
?>
