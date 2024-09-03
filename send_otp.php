<?php
// send_otp.php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Adjust the path as needed

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Generate a random OTP
    $otp = rand(100000, 999999);

    // Save OTP to the session with the user's email
    session_start();
    $_SESSION['otp'] = $otp;
    $_SESSION['email'] = $email;

    // Send OTP to user's email using PHPMailer
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'benardodero21@gmail.com'; // SMTP username
        $mail->Password = 'nfzm oxyi jstv auxp';           // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
        $mail->Port = 587;

        //Recipients
        $mail->setFrom('benardodero21@gmail.com', 'Benard Odero');
        $mail->addAddress($email);     // Add a recipient dynamically

        // Content
        $mail->isHTML(false);                                  // Set email format to HTML
        $mail->Subject = 'Password Reset!';
        $mail->Body    = 'Your OTP for password reset is: ' . $otp;

        $mail->send();
        echo "OTP sent to your email.";

    } catch (Exception $e) {
        echo "Failed to send OTP. Error: {$mail->ErrorInfo}";
    }

    // Redirect to OTP verification page
    header("Location: verify_otp.php");
    exit();
}
?>
