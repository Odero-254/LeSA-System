<?php
session_start();
if (!isset($_SESSION['otp'])) {
    header("Location: login.php");
    exit();
}

$email = filter_input(INPUT_GET, 'email', FILTER_VALIDATE_EMAIL);
$message = isset($_GET['message']) ? htmlspecialchars($_GET['message']) : '';
$type = isset($_GET['type']) ? htmlspecialchars($_GET['type']) : '';
?>

<?php include 'header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>OTP Verification</title>
    <link rel="shortcut icon" href="dist/img/favicon.ico">
    <link rel="stylesheet" href="styles2.css"> <!-- Link to CSS file -->
    <script>
        function startCountdown() {
            var resendLink = document.getElementById('resend-link');
            var countdownTimer = document.getElementById('countdown-timer');
            var countdown = 60; // 60 seconds countdown

            // Update the timer every second
            var timer = setInterval(function() {
                countdown--;
                countdownTimer.textContent = "Resend in 00:"+ countdown;
                if (countdown <= 0) {
                    clearInterval(timer);
                    resendLink.style.display = "inline"; // Show the resend link
                    countdownTimer.style.display = "none"; // Hide the countdown text
                }
            }, 1000);
        }

        // Start the countdown when the page loads
        window.onload = function() {
            startCountdown();
        };
    </script>
</head>
<body>

<?php
if ($message) {
    echo "<div class='alert alert-$type'>$message</div>";
}
?>

<h1>OTP Verification</h1>
<p>You are required to verify your identity one more time</p> <br><br>
<form action="verify_otp.php" method="post">
    <div class="input-group">
        <label for="otp">Enter OTP sent to your email*</label>
        <input type="text" name="otp" placeholder="Enter OTP sent to you" required>
        <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">
    </div>
        <div class="button-group">
            <button type="button" class="button" onclick="window.location.href='login.php';">Back</button>
            <button type="submit" class="button">Next</button>    
        </div>
    <p>Didn't receive OTP? 
        <span id="countdown-timer">30 seconds</span>
        <a href="resend_otp.php?email=<?php echo urlencode($email); ?>" id="resend-link" style="display:none;">Resend</a>
    </p>
</form>
</body>
</html>
