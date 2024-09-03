<?php
//import PHPMailer classes into the global namespace 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoload
require "vendor/autoload.php";
require "./settings_mail.php";


    $mail               = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host         = $host;
    $mail->SMTPAuth     = true;
    $mail->Username     = $username;
    $mail->Password     = $hostPassword;
    $mail->SMTPSecure   = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port         = 465;