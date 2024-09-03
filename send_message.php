<?php
// Check if session is not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('includes/config.php');

// Check if user is logged in
if (strlen($_SESSION['user_id']) == 0) {
    header('location: logout.php');
    exit();
} else {
    // Update last activity time to extend session
    $_SESSION['last_active_time'] = time();

    $user_id = $_SESSION['user_id'];

    // Fetch user details including user_role
    $stmt = $conn->prepare("SELECT user_role FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($user_role);
    $stmt->fetch();
    $stmt->close();

    // Handle message sending
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $recipient_id = $_POST['recipient_id'];
        $message_content = $_POST['message_content'];
        $file = $_FILES['file'];

        if (empty($recipient_id)) {
            echo "<script>alert('Please select a recipient.');</script>";
        } elseif (empty($message_content) && empty($file['name'])) {
            echo "<script>alert('Message cannot be blank. Please write a message or attach a file.');</script>";
        } else {
            $file_name = '';
            if (!empty($file['name'])) {
                $file_name = time() . '_' . $file['name'];
                $target_dir = "uploads/";
                $target_file = $target_dir . basename($file_name);
                move_uploaded_file($file['tmp_name'], $target_file);
            }

            // Insert message into database
            $stmt = $conn->prepare("INSERT INTO messages (sender_id, recipient_id, message, file, timestamp) VALUES (?, ?, ?, ?, NOW())");
            $stmt->bind_param("iiss", $user_id, $recipient_id, $message_content, $file_name);
            $stmt->execute();
            $stmt->close();

            echo "<script>alert('Message sent successfully!');</script>";
            echo "<script>window.location.href='home.php';</script>";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Message</title>
    <link rel="shortcut icon" href="dist/img/favicon.ico">
    <link href="vendors/jquery-toggles/css/toggles.css" rel="stylesheet" type="text/css">
    <link href="vendors/jquery-toggles/css/themes/toggles-light.css" rel="stylesheet" type="text/css">
    <link href="dist/css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
    <div class="hk-wrapper hk-vertical-nav">
        <?php include_once('includes/navbar.php'); ?>
        <?php include_once('includes/sidebar.php'); ?>
        <div id="hk_nav_backdrop" class="hk-nav-backdrop"></div>
        <div class="hk-pg-wrapper">
            <nav class="hk-breadcrumb" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-light bg-transparent">
                    <li class="breadcrumb-item"><a href="dashboard_admin.php">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Send Message</li>
                </ol>
            </nav>
            <div class="container">
                <div class="hk-pg-header">
                    <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="external-link"></i></span></span>Send Message</h4>
                </div>
                <div class="row">
                    <div class="col-xl-12">
                        <section class="hk-sec-wrapper">
                            <div class="row">
                                <div class="col-sm">
                                    <form method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                        <h3>Message</h3>
                                        <label for="recipient">Recipient:</label>
                                        <select name="recipient_id" id="recipient" required>
                                            <option value="">Select Recipient</option>
                                            <?php
                                            // Display options based on user_role
                                            $stmt = $conn->prepare("SELECT id, username, user_role FROM users WHERE id != ?");
                                            $stmt->bind_param("i", $user_id);
                                            $stmt->execute();
                                            $stmt->bind_result($recipient_id, $recipient_username, $recipient_role);
                                            
                                            while ($stmt->fetch()) {
                                                // Limit options based on user_role
                                                if ($user_role === 'Principal' && in_array($recipient_role, ['Deputy Principal', 'HOD', 'Lecturer', 'Class Representative'])) {
                                                    echo "<option value='$recipient_id'>$recipient_username - $recipient_role</option>";
                                                } elseif ($user_role === 'HOD' && in_array($recipient_role, ['Deputy Principal', 'Principal', 'Lecturer', 'Class Representative'])) {
                                                    echo "<option value='$recipient_id'>$recipient_username - $recipient_role</option>";
                                                } elseif ($user_role === 'Deputy Principal' && in_array($recipient_role, ['Principal', 'HOD', 'Lecturer', 'Class Representative'])) {
                                                    echo "<option value='$recipient_id'>$recipient_username - $recipient_role</option>";
                                                } elseif ($user_role === 'Lecturer' && in_array($recipient_role, ['HOD', 'Class Representative'])) {
                                                    echo "<option value='$recipient_id'>$recipient_username - $recipient_role</option>";
                                                } elseif ($user_role === 'Class Representative' && $recipient_role === 'Class Representative') {
                                                    echo "<option value='$recipient_id'>$recipient_username - $recipient_role</option>";
                                                }
                                            }
                                            $stmt->close();
                                            ?>
                                        </select>
                                        <br><br>
                                        <label for="message">Write your message here or attach a file:</label><br>
                                        <textarea name="message_content" id="message" rows="4" cols="50"></textarea><br><br>
                                        <input type="file" name="file"><br><br>
                                        <button class="btn btn-primary" type="submit" name="submit">Send Message</button>
                                    </form>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="vendors/jquery/dist/jquery.min.js"></script>
    <script src="vendors/popper.js/dist/umd/popper.min.js"></script>
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="vendors/jasny-bootstrap/dist/js/jasny-bootstrap.min.js"></script>
    <script src="dist/js/jquery.slimscroll.js"></script>
    <script src="dist/js/dropdown-bootstrap-extended.js"></script>
    <script src="dist/js/feather.min.js"></script>
    <script src="vendors/jquery-toggles/toggles.min.js"></script>
    <script src="dist/js/toggle-data.js"></script>
    <script src="dist/js/init.js"></script>
    <script>
    var inactiveTimeout = <?php echo 60; ?>; 
    var idleTimer;

    function resetIdleTimer() {
        clearTimeout(idleTimer);
        idleTimer = setTimeout(logoutUser, inactiveTimeout * 1000);
    }

    function logoutUser() {
        window.location.href = 'logout.php'; // Redirect to logout page or login page
    }

    // Set up event listeners to reset idle timer on user activity
    document.addEventListener('mousemove', resetIdleTimer);
    document.addEventListener('mousedown', resetIdleTimer);
    document.addEventListener('keypress', resetIdleTimer);
    document.addEventListener('scroll', resetIdleTimer);

    // Initialize the idle timer on page load
    resetIdleTimer();
    </script>
</body>
</html>

<?php
    $conn->close();
}
?>
