<?php
// Start the session
session_start();

// Check if "Remember Me" cookie is set and user is not already logged in
if (!isset($_SESSION['user_id']) && isset($_COOKIE['remember_user_id'])) {
    $_SESSION['user_id'] = $_COOKIE['remember_user_id'];
    $_SESSION['last_active_time'] = time();
    header('Location: login.php'); // Redirect to the protected page
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NYSEI LeSAS | Login</title>
    <link rel="shortcut icon" href="dist/img/favicon.ico">
    <link rel="stylesheet" href="styles2.css">
    <script>
        function togglePassword() {
            var passwordField = document.getElementById('password');
            var eyeIcon = document.getElementById('eye-icon');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                eyeIcon.innerHTML = '&#128065;'; // Open eye icon
            } else {
                passwordField.type = 'password';
                eyeIcon.innerHTML = '&#128274;'; // Closed eye icon
            }
        }

        function handleFormSubmit(event) {
            var submitButton = document.getElementById('login-button');
            submitButton.disabled = true; // Disable the button to prevent multiple submissions
            submitButton.innerText = 'Validating details...please wait'; // Change button text
        }
        function goBack() {
            window.history.back(); // Navigate to the previous page
        }
    </script>
</head>
<body>
    <div class="header">
        <img src="dist/img/comb_logo.png" alt="nysei Logo" class="logo">
    </div>
    <h1>One Login</h1>
    <p>Sign in to your account to continue.</p>
        
    <?php
    if (isset($_GET['message'])) {
        $message = htmlspecialchars($_GET['message']);
        $message_type = htmlspecialchars($_GET['type']);
        echo "<p class='message $message_type'>$message</p>";
    }
    ?>
    <form action="authenticate.php" method="post" onsubmit="handleFormSubmit(event)">
        <div class="input-group">
            <label for="email">Email Address*</label>
            <input type="email" id="email" name="email" placeholder="name@example.com" required>
        </div>
        <div class="input-group">
            <label for="password">Password*</label>
            <input type="password" id="password" name="password" placeholder="Password" required>
            <span class="eye-icon" id="eye-icon" onclick="togglePassword()">&#128274;</span> <!-- Closed eye icon -->
        </div>
        <div class="options">
            <label>
                <input type="checkbox" name="remember"> Remember for 10 days
            </label>
            <a href="reset_password.php" class="forgot-password">Forgot Password</a>
        </div>
        
            
            <button type="submit" id="login-button" class="login-button">Sign In</button>

        
    </form>
    <p class="request-link">Don't have an account? <a href="request_account.php">Request Now</a></p>
</body>
</html>
