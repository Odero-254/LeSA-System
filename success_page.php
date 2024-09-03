<?php
// Check if session is not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('includes/config.php');

if (strlen($_SESSION['user_id']) == 0) {
    header('location: logout.php');
    exit();
}

// Assuming you have stored user details in session
$username = isset($_SESSION['user_data']['username']) ? $_SESSION['user_data']['username'] : '';
$email = isset($_SESSION['user_data']['emailaddress']) ? $_SESSION['user_data']['emailaddress'] : '';
$qualifiedSubjects = isset($_SESSION['qualified_subjects']) ? $_SESSION['qualified_subjects'] : [];

// Clear the session data if necessary
// unset($_SESSION['user_data']);
// unset($_SESSION['qualified_subjects']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Success</title>
    <link rel="stylesheet" href="path_to_your_stylesheet.css">
</head>
<body>
    <div class="container">
        <h1>Registration Successful</h1>
        <p>Thank you for registering, <strong><?php echo htmlspecialchars($username); ?></strong>.</p>
        <p>Your account has been created successfully. A confirmation email has been sent to <strong><?php echo htmlspecialchars($email); ?></strong> with your login details.</p>
        
        <?php if (!empty($qualifiedSubjects)): ?>
        <h2>Qualified Subjects</h2>
        <ul>
            <?php foreach ($qualifiedSubjects as $subject): ?>
            <li><?php echo htmlspecialchars($subject); ?></li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>

        <a href="login.php" target="_blank">Click here to login</a>
    </div>
</body>
</html>
