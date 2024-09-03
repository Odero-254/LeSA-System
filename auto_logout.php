
<?php
session_start(); // Start the session

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Automatic Logout</title>
    <link rel="shortcut icon" href="dist/img/favicon.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            text-align: center;
            background-color: #f0f8f8;
        }
        .container {
            max-width: 600px;
            margin: 60px auto;
            padding: 20px;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
            border-radius: 10px;
        }
        h1 {
            color: #ff0000;
        }
        /* Back to Home Button Styles */
a.back-button {
    display: inline-block;
    padding: 10px 30px;
    background-color: #0056b3;
    color: #ffffff;
    text-decoration: none;
    border-radius: 50px;
    font-size: 0.9em;
    transition: background-color 0.3s, transform 0.2s;
    margin-top: 20px;
}

a.back-button:hover {
    background-color: #004494;
    transform: scale(1.05);
}
.logo {
    width: 150px; /* Adjust the width to reduce the size */
    height: auto; /* Maintain the aspect ratio */
    display: block;
    margin: 0 auto; /* Center the logo */
}
/* General styles for copyright and links */
footer p {
    font-size: 0.9em;
    color: #777;
    text-align: center;
    margin-top: 5px; /* Reduced top margin for closer spacing */
    margin-bottom: 0; /* Removed bottom margin */
}

/* General styles for copyright and links */
footer {
    display: flex; /* Use flexbox to arrange items in a row */
    flex-direction: row; /* Set direction to row */
    justify-content: center; /* Center items horizontally */
    align-items: center; /* Center items vertically */
    flex-wrap: wrap; /* Allow wrapping if necessary */
    font-size: 0.9em; /* Consistent font size */
    color: #777; /* Text color */
    margin-top: 5px; /* Reduced top margin for closer spacing */
    margin-bottom: 0; /* Removed bottom margin */
}

/* Link styles */
footer a {
    text-decoration: none; /* Remove underline */
    color: #0056b3; /* Link color */
    transition: text-decoration 0.3s; /* Smooth transition for underline */
    margin: 0 10px; /* Add horizontal space between links */
}

/* Underline effect on hover */
footer a:hover {
    text-decoration: underline; /* Show underline on hover */
}

    </style>
</head>
<body>
    <div class="container">
    <img src="dist/img/comb_logo.png" alt="LeSA Logo" class="logo">
        <h1>Automatic System Logout</h1>
        <p>
            You have been automatically logged out for security reasons due to inactivity.<br>
            To avoid being logged out, please keep your session  active by regularly<br>
            interacting with the page, such as clicking, typing, or scrolling.<br>
            
        </p>
        <p><a href="login.php" class="back-button"><i class="fas fa-sign-out-alt"></i>Login again</a></p>
    </div>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> NYSEI LeSA System. All rights reserved.</p>
        <a href="terms.html" class="terms-link"><i class="fas fa-file-alt"></i> Terms & Conditions</a>
        <a href="privacy.html" class="privacy-link"><i class="fas fa-file-alt"></i> Privacy Policy</a>
    </footer>

</footer>
    
</body>
</html>
