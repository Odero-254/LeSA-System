<?php

$error_message = ""; // Initialize error message variable

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the submitted form data
    $email = $_POST['email'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $current_password = $_POST['current_password'];

    // Check if new password and confirm password match
    if ($new_password !== $confirm_password) {
        $error_message = "Passwords do not match. Please try again.";
    } else {
        // Create a database connection
        $conn = new mysqli('localhost', 'root', '', 'nysei_lesa');

        // Check the connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Check if the email exists in the database
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Email exists, now check the current password
            $user = $result->fetch_assoc();
            $stored_password = $user['password'];

            if (password_verify($current_password, $stored_password)) {
                // Current password matches, update the password
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $update_sql = "UPDATE users SET password = ?, first_login = 0 WHERE email = ?";
                $update_stmt = $conn->prepare($update_sql);
                $update_stmt->bind_param("ss", $hashed_password, $email);

                if ($update_stmt->execute()) {
                    // Password changed successfully, redirect to login page
                    header("Location: login.php?message=Password changed successfully, please log in again&type=success");
                    exit();
                } else {
                    $error_message = "Error updating password: " . $update_stmt->error;
                }

                $update_stmt->close();
            } else {
                $error_message = "Current password is incorrect. Please try again.";
            }
        } else {
            $error_message = "Email does not exist. Please try again.";
        }

        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link rel="shortcut icon" href="dist/img/favicon.ico">
    <link rel="stylesheet" href="styles2.css">
</head>
<body>
    
        <h1>Change Password</h1>
        <p>Let's help you change your password</p>

        <?php if (!empty($error_message)) : ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <form action="change_password.php" method="post">
        <div class="input-group">
            <label for="email">Enter your Email*</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="input-group">
            <label for="current_password">Current Password*</label>
            <input type="password" id="current_password" name="current_password" required>
        </div>
        <div class="input-group">
            <label for="new_password">New Password*</label>
            <input type="password" id="new_password" name="new_password" required>
        </div>
        <div class="input-group">
            <label for="confirm_password">Confirm New Password*</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
        </div>
        <button type="submit" id="change-password-button" class="change-password-button">Change Password</button>    
    
        </form>
   
</body>
</html>
