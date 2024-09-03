<?php
session_start();
require_once 'includes/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $otp = filter_input(INPUT_POST, 'otp', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

    if (!$otp || !$email) {
        header("Location: otp_form.php?email=" . urlencode($email) . "&message=Please fill in all fields&type=error");
        exit();
    }

    if (isset($_SESSION['otp'], $_SESSION['otp_expires'])) {
        if ($_SESSION['otp'] == $otp && time() < $_SESSION['otp_expires']) {
            // OTP is valid, log the user in
            $stmt = $conn->prepare("SELECT id, username, user_role, department_id FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->bind_result($id, $username, $user_role, $department_id);
            $stmt->fetch();

            if ($id) {
                // Set session variables
                $_SESSION['user_id'] = $id;
                $_SESSION['username'] = $username;
                $_SESSION['email'] = $email;
                $_SESSION['user_role'] = $user_role;
                $_SESSION['department_id'] = $department_id;

                // Clear OTP from session
                unset($_SESSION['otp']);
                unset($_SESSION['otp_expires']);

                // Redirect to the last visited page or home
                if (isset($_SESSION['last_page'])) {
                    $last_page = $_SESSION['last_page'];
                    unset($_SESSION['last_page']);
                    $stmt->close();
                    header("Location: $last_page");
                    exit();
                } else {
                    $stmt->close();
                    header("Location: home.php");
                    exit();
                }
            } else {
                // User not found
                $stmt->close();
                header("Location: login.php?message=User not found. Please try again.&type=error");
                exit();
            }
        } elseif (time() >= $_SESSION['otp_expires']) {
            // OTP has expired
            header("Location: otp_form.php?email=" . urlencode($email) . "&message=This OTP has expired. Please request a new one.&type=error");
            exit();
        } else {
            // Invalid OTP
            header("Location: otp_form.php?email=" . urlencode($email) . "&message=Invalid OTP. Please try again.&type=error");
            exit();
        }
    } else {
        // No OTP found in session
        header("Location: otp_form.php?email=" . urlencode($email) . "&message=No OTP found. Please request a new one.&type=error");
        exit();
    }
} else {
    // Redirect if not a POST request
    header("Location: login.php?message=System encountered an error!&type=error");
    exit();
}
?>
