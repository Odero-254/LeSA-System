<?php
// Check if session is not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once 'includes/config.php';
require 'vendor/autoload.php'; // Include PHPMailer autoload file

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['email'])) {
    $email = filter_input(INPUT_GET, 'email', FILTER_VALIDATE_EMAIL);

    if (!$email) {
        header("Location: login.php?message=Invalid email address&type=error");
        exit();
    }

    // Generate and send new OTP
    $otp = rand(100000, 999999);
    $_SESSION['otp'] = $otp;
    $_SESSION['otp_expires'] = time() + 300; // OTP expires in 5 minutes

    // Send OTP via email using PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'benardodero21@gmail.com';
        $mail->Password = 'nfzm oxyi jstv auxp';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('benardodero21@gmail.com', 'NYSEI LeSA Admin Team');
        $mail->addAddress($email);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'OTP Verification Code';
        $mail->Body = "Your One Time verification code (OTP) is: $otp.<br> this OTP will expire if not used within 5 minutes <br> from the time requested.";

        $mail->send();
        header("Location: otp_form.php?email=" . urlencode($email) . "&message=OTP resent successfully&type=success");
        exit();
    } catch (Exception $e) {
        header("Location: login.php?message=Could not resend OTP. Please try again.&type=error");
        exit();
    }
} else {
    header("Location: login.php?message=System encountered an error!&type=error");
    exit();
}
?>
