<?php
session_start();
require_once 'includes/config.php';
require 'vendor/autoload.php'; // Include PHPMailer autoload file

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Enable error reporting (for debugging purposes)
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and validate inputs
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    // Check if email and password are provided
    if (!$email || !$password) {
        header("Location: login.php?message=Please fill in all fields&type=error");
        exit();
    }

    // Prepare SQL statement to fetch user details including hashed password
    $stmt = $conn->prepare("SELECT id, username, email, user_role, password, first_login, department_id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Bind result variables
        $stmt->bind_result($id, $username, $email, $user_role, $stored_password, $first_login, $department_id);
        $stmt->fetch();

        // Verify hashed password
        if (password_verify($password, $stored_password)) {
            // Check if the user is logging in for the first time
            if ($first_login == 1) {
                // Store user details in session and redirect to change password page
                $_SESSION['user_id'] = $id;
                $_SESSION['username'] = $username;
                $_SESSION['email'] = $email;
                $_SESSION['user_role'] = $user_role;
                $_SESSION['first_login'] = $first_login;
                $_SESSION['department_id'] = $department_id;

                // Redirect to the change password page
                header("Location: change_password.php?message=Please change your password before proceeding&type=info");
                exit();
            }

            // Check if "Remember Me" is selected
            if (isset($_POST['remember'])) {
                setcookie('remember_user_id', $id, time() + (10 * 24 * 60 * 60), "/"); // Set cookie for 10 days
            }

            // Generate and send OTP
            $otp = rand(100000, 999999);
            $_SESSION['otp'] = $otp;
            $_SESSION['otp_expires'] = time() + 300; // OTP expires in 5 minutes
            $_SESSION['user_id'] = $id; // Set session user_id
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
            $_SESSION['user_role'] = $user_role;
            $_SESSION['first_login'] = $first_login;
            $_SESSION['department_id'] = $department_id;

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
                $mail->addAddress($email, $username);

                // Content
                $mail->isHTML(true);
                $mail->Subject = 'OTP Verification Code';
                $mail->Body = "Your One Time verification code (OTP) is: $otp. <br> This OTP will expire if not used within 5 minutes <br> from the time requested.";

                $mail->send();
            } catch (Exception $e) {
                header("Location: login.php?message=Could not send OTP. Connection error.&type=error");
                exit();
            }

            // Redirect to OTP form
            header("Location: otp_form.php?email=" . urlencode($email));
            exit();
        } else {
            // Invalid credentials
            $stmt->close();
            header("Location: login.php?message=Invalid credentials&type=error");
            exit();
        }
    } else {
        // No account found
        $stmt->close();
        header("Location: login.php?message=No user account found&type=error");
        exit();
    }
} else {
    // Redirect if not a POST request
    header("Location: login.php?message=System encountered an error!&type=error");
    exit();
}
?>
