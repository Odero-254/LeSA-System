<?php
// Include necessary files and libraries
require 'vendor/autoload.php';
require_once 'includes/config.php';
include 'header.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Initialize variables
$error = '';
$otpSent = false;
$otpValid = false;
$passwordReset = false;

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['send_otp'])) {
        $email = $_POST['email'];
        $otp = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
        $otp_expiry = time() + 120; // OTP expiry set to 120 seconds from now

        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $sql_update_statement = "UPDATE users SET otp = ?, otp_expiry = ? WHERE email = ?";
            $stmt = $conn->prepare($sql_update_statement);
            $stmt->bind_param("sis", $otp, $otp_expiry, $email);
            $stmt->execute();

            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'benardodero21@gmail.com';
                $mail->Password = 'nfzm oxyi jstv auxp';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('benardodero21@gmail.com', 'NYSEI LeSA Team');
                $mail->addAddress($email);

                $mail->isHTML(true);
                $mail->Subject = 'Your OTP for Password Reset';
                $mail->Body = 'Your OTP is <b>' . $otp . '</b>. Please use it within 2 minutes.';

                $mail->send();
                $otpSent = true;
            } catch (Exception $e) {
                $error = 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
            }
        } else {
            $error = "Email address not found.";
        }
        $stmt->close();
    }

    if (isset($_POST['validate_otp'])) {
        $email = $_POST['email'];
        $entered_otp = $_POST['otp'];

        $current_time = time();
        $sql = "SELECT otp, otp_expiry FROM users WHERE email = ? AND otp = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $email, $entered_otp);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $stored_otp = $row['otp'];
            $otp_expiry = $row['otp_expiry'];

            if ($stored_otp === $entered_otp && $otp_expiry >= $current_time) {
                $otpValid = true;
            } else {
                $error = "Invalid or expired OTP. Please request a new one.";
            }
        } else {
            $error = "Invalid OTP.";
        }
        $stmt->close();
    }

    if (isset($_POST['reset_password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        if ($password === $confirm_password) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $sql_update_password = "UPDATE users SET password = ?, otp = NULL WHERE email = ?";
            $stmt = $conn->prepare($sql_update_password);
            if ($stmt->bind_param("ss", $hashed_password, $email) && $stmt->execute()) {
                $passwordReset = true;
            } else {
                $error = "Error updating password. Please try again.";
            }
            $stmt->close();
        } else {
            $error = "Passwords do not match. Please try again.";
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="shortcut icon" href="dist/img/favicon.ico">
    <link rel="stylesheet" href="styles2.css"> 
</head>
<body>
   
    <h1>Forgot Password</h1>
    <p>Let's help you reset your password</p> <br>
        <?php if (!empty($error)) echo '<p style="color:red;">' . $error . '</p>'; ?>

        <?php if ($otpSent): ?>
            <form action="reset_password.php" method="post">
                <div class="input-group">
                    <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">
                    <label for="otp">Enter OTP sent to your email*</label>
                    <input type="text" id="otp" name="otp" required>
                </div>
                <button type="submit" name="validate_otp">Validate OTP</button>
            </form>
        <?php elseif ($otpValid): ?>
            <form action="reset_password.php" method="post">
                <div class="input-group">
                    <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">
                    <label for="password">New Password*</label>
                    <input type="password" id="password" name="password" required>
                    <label for="confirm_password">Confirm Password*</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>
                <button type="submit" name="reset_password">Reset Password</button>
            </form>
        <?php elseif ($passwordReset): ?>
            <p>Password has been reset successfully.</p>
            <p><a href="login.php">Click here to login</a></p>
        <?php else: ?>
            <form action="reset_password.php" method="post">
                <div class="input-group">
                    <label for="email">Enter your Email address*</label>
                    <input type="email" id="email" name="email" required>
                </div>
                
                <button type="submit" name="send_otp">Validate email</button>
            </form>
            <p class="request-link">Remembered password? <a href="login.php">Sign In</a></p>
            <p class="request-link">Don't have an account? <a href="request_account.php">Request One</a></p>
            
        <?php endif; ?>
    
</body>
</html>
