<?php
// Check if session is not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require 'db_connection.php';
require 'vendor/autoload.php'; // Autoload PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if all required fields are set
    if (isset($_POST['name'], $_POST['email'], $_POST['phone_number'], $_POST['department_id'], $_POST['qualifications'])) {
        // Get input values from the form
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone_number = $_POST['phone_number'];
        $department_id = $_POST['department_id'];
        $qualifications = $_POST['qualifications'];

        // Convert qualifications string to JSON array
        $qualificationsArray = explode(',', $qualifications);
        $qualificationsJson = json_encode($qualificationsArray);

        // Generate random password
        $password = bin2hex(random_bytes(4)); // Generates a random 8-character password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare SQL statement
        $sql = "INSERT INTO users (name, email, phone_number, department_id, qualifications, password) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        // Check if the statement was prepared successfully
        if (!$stmt) {
            die("Prepare statement failed: (" . $conn->errno . ") " . $conn->error);
        }

        $stmt->bind_param("ssssss", $name, $email, $phone_number, $department_id, $qualificationsJson, $hashed_password);

        // Execute statement and check for success
        if ($stmt->execute()) {
            // Send email with login credentials
            $mail = new PHPMailer(true);

            try {
                //Server settings
                $mail->SMTPDebug = 0;                      // Enable verbose debug output
                $mail->isSMTP();                           // Set mailer to use SMTP
                $mail->Host       = 'smtp.gmail.com';      // Specify main and backup SMTP servers
                $mail->SMTPAuth   = true;                  // Enable SMTP authentication
                $mail->Username   = 'benardodero21@gmail.com';// SMTP username
                $mail->Password   = 'nfzm oxyi jstv auxp';       // SMTP password
                $mail->SMTPSecure = 'tls';                 // Enable TLS encryption, `ssl` also accepted
                $mail->Port       = 587;                   // TCP port to connect to

                //Recipients
                $mail->setFrom('benardodero21@gmail.com', 'benard Odero');
                $mail->addAddress($email);                 // Add a recipient

                // Content
                $mail->isHTML(true);                       // Set email format to HTML
                $mail->Subject = 'Your New Account';
                $mail->Body    = "Your account has been created. <br>Username: $email<br>Password: $password";
                $mail->AltBody = "Your account has been created. \nUsername: $email\nPassword: $password";

                $mail->send();
                echo 'New user added successfully and email sent!';
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error: Required form data is missing.";
    }
}
?>
