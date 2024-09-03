<?php
// Check if session is not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if a message exists in the session
$message = isset($_SESSION['message']) ? $_SESSION['message'] : '';
$message_type = isset($_SESSION['message_type']) ? $_SESSION['message_type'] : '';

// Clear the session message after displaying it
unset($_SESSION['message']);
unset($_SESSION['message_type']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Allocation Status</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Example styles for alert messages */
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
        }
        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }
        .alert-warning {
            color: #856404;
            background-color: #fff3cd;
            border-color: #ffeeba;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Lesson Allocation Status</h1>
        
        <!-- Display the message if it exists -->
        <?php if (!empty($message)): ?>
            <div class="alert <?php echo ($message_type === 'success') ? 'alert-success' : 'alert-warning'; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <p>The lesson allocation process has been completed. Please review the status above.</p>

        <a href="manage_allocations.php" class="btn btn-primary">Manage Allocations</a>
    </div>
</body>
</html>
