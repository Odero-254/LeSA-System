<?php
// Check if session is not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('includes/config.php');
require 'vendor/autoload.php'; // Adjust the path as necessary

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ensure user is logged in
    if (strlen($_SESSION['user_id']) == 0) {
        header('location: logout.php');
        exit();
    }

    // Get data from the previous steps
    $userData = $_SESSION['user_data'];
    $roleData = $_SESSION['role_data'];

    // Generate a random password
    $password = bin2hex(random_bytes(4));

    // Initialize qualifiedSubjects array
    $qualifiedSubjects = [];

    // Start a transaction
    $conn->begin_transaction();

    try {
        // Ensure username is not null
        $username = !empty($userData['username']) ? $userData['username'] : '';

        // Check if the username already exists
        $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        if ($count > 0) {
            throw new Exception("Username already exists. Please choose a different username.");
        }

        // Save user to database
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (username, email, phone_number, user_role, department_id, password) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssis", $username, $userData['emailaddress'], $userData['phoneNumber'], $roleData['role'], $roleData['department'], $hashedPassword);
        $stmt->execute();
        $userId = $stmt->insert_id;
        $stmt->close();

        // If the user role is Lecturer, save additional details in the lecturers table
        if ($roleData['role'] == 'Lecturer') {
            $stmt = $conn->prepare("INSERT INTO lecturers (username, email, password, user_id) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("sssi", $username, $userData['emailaddress'], $hashedPassword, $userId);
            $stmt->execute();
            $stmt->close();

            // Retrieve qualified subjects based on qualifications
            $qualifications = $roleData['qualifications']; // Assuming qualifications is an array of subject IDs
            foreach ($qualifications as $subjectId) {
                $stmt = $conn->prepare("SELECT name FROM subjects WHERE id = ?");
                $stmt->bind_param("i", $subjectId);
                $stmt->execute();
                $stmt->bind_result($subjectName);
                while ($stmt->fetch()) {
                    $qualifiedSubjects[] = $subjectName;
                }
                $stmt->close();
            }

            // Store qualified subjects in the lecturers table
            $qualifiedSubjectsString = implode(', ', $qualifiedSubjects);
            $stmt = $conn->prepare("UPDATE lecturers SET qualified_subjects = ? WHERE user_id = ?");
            $stmt->bind_param("si", $qualifiedSubjectsString, $userId);
            $stmt->execute();
            $stmt->close();
        }

        // Commit the transaction
        $conn->commit();

        // Send email with login credentials using PHPMailer
        $mail = new PHPMailer(true);
        try {
            // SMTP configuration
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'benardodero21@gmail.com';
            $mail->Password = 'nfzm oxyi jstv auxp';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            // Sender and recipient settings
            $mail->setFrom('benardodero21@gmail.com', 'LeSAS Admin Team');
            $mail->addAddress($userData['emailaddress']);

            // Email content
            $mail->isHTML(true);
            $mail->Subject = 'Your Login Credentials';
            $mail->Body = "Dear " . $userData['username'] . ",<br><br>"
                . "Your account has been created. Here are your login details:<br><br>"
                . "Username: " . $username . "<br>"
                . "Password: " . $password . "<br><br>"
                . "Please change your password after logging in for the first time.<br><br>"
                . "Regards,<br>"
                . "Admin Team";

            // Send email
            $mail->send();

            // Display success message and redirect
            echo "<script>
                alert('Registration successful.\\n\\nUsername: " . $username . "\\nPassword: " . $password . "\\nQualified Subjects: " . implode(', ', $qualifiedSubjects) . "');
                window.location.href = 'success_page.php';
            </script>";

        } catch (Exception $e) {
            // Rollback the transaction on error
            $conn->rollback();
            echo "<script>alert('Error sending email: " . $mail->ErrorInfo . "');</script>";
        }

    } catch (Exception $e) {
        // Rollback the transaction on error
        $conn->rollback();
        echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
    }

    $conn->close();
}
?>
