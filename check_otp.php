<?php

// Check if session is not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once 'includes/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $entered_otp = $_POST['otp'];
    $saved_otp = $_SESSION['otp'];

    if ($entered_otp == $saved_otp) {
        // OTP is correct, redirect to change password page
        header("Location: change_password.php");
        exit();
    } else {
        echo "Invalid OTP. Please try again.";
    }
}
?>
