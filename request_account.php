<?php
include 'header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Account</title>
    <link rel="shortcut icon" href="dist/img/favicon.ico">
    <link rel="stylesheet" href="styles2.css"> 
    
    
</head>

<body>
    

    <h1>Request Account</h1>
    <div class="input-group">
        <!-- Alert Messages -->
        <?php 
        // Check if session is not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
        if (!empty($_SESSION['alertMessage'])): ?>
            <div class="alert alert-<?php echo $_SESSION['alertType']; ?>">
                <span><?php echo $_SESSION['alertMessage']; ?></span>
                <span class="close" onclick="this.parentElement.style.display='none';">&times;</span>
            </div>
            <?php
            // Clear alert message after displaying
            unset($_SESSION['alertMessage']);
            unset($_SESSION['alertType']);
        endif; ?>
    </div>

    
        <form action="process_request.php" method="POST">
            <div class="input-group">
                <label for="name">Enter your Full Name*</label>
                <input type="text" name="name" placeholder="enter your name" >
            </div>
            <div class="input-group">
                <label for="phone">Enter your phone number*</label>
                <input type="text" name="phone" placeholder="enter phone Number" > 
            </div>
            <div class="input-group">
                <label for="department">Enter the name of your department*</label>
                <input type="text" name="department" placeholder="Name of your department" >
            </div>
                <button type="submit" id="request-button" class="request-button">Send Request</button>
           
                
        </form>
        <p class="request-link">Already have an account? <a href="login.php">Sign In</a></p>
       
    
</body>
</html>
