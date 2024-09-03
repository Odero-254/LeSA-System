<?php
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Database connection
require_once 'includes/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $role = $_POST['role'];
    $password = 'generated_password'; // Generate or define a password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (username, email, phone_number, role, password) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $username, $email, $phone_number, $role, $hashed_password);

    if ($stmt->execute()) {
        echo "User added successfully.";

        $mail = new PHPMailer(true);
        try {
            // Server settings
            $mail->SMTPDebug = 2; // Enable verbose debug output (set to 0 for no debug output)
            $mail->isSMTP(); // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com'; // Specify main and backup SMTP servers
            $mail->SMTPAuth = true; // Enable SMTP authentication
            $mail->Username = 'benardodero21@gmail.com'; // SMTP username (your Gmail address)
            $mail->Password = 'nfzm oxyi jstv auxp'; // SMTP password (your Gmail password)
            $mail->SMTPSecure = 'tls'; // Enable Transport Layer Security encryption
            $mail->Port = 587; // TCP port to connect to

            // Recipients
            $mail->setFrom('benardodero21@gmail.com', 'Benard Odero'); // Sender's email and name
            $mail->addAddress($email, $username); // Add a recipient dynamically

            // Content
            $mail->isHTML(true); // Set email format to HTML
            $mail->Subject = 'Welcome to the NYSEI LeSA System';
            $mail->Body    = 'Hello ' . $username . ',<br>Your account has been created. Your password is: <b>' . $password . '</b>';
            $mail->AltBody = 'Hello ' . $username . ',\nYour account has been created. Your password is: ' . $password;

            $mail->send();
            echo 'Password email has been sent';
        } catch (Exception $e) {
            echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        }
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
