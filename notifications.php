<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('includes/config.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Update last activity time to extend session
$_SESSION['last_active_time'] = time();

// Fetch user role and user details
$user_query = $conn->prepare("SELECT user_role, username, email, phone_number FROM users WHERE id = ?");
$user_query->bind_param('i', $user_id);
$user_query->execute();
$user_result = $user_query->get_result();
if ($row = $user_result->fetch_assoc()) {
    $user_role = $row['user_role'];
    $user_info = [
        'username' => $row['username'],
        'email' => $row['email'],
        'phone_number' => $row['phone_number']
    ];
} else {
    echo "User information could not be retrieved.";
    exit();
}

// Fetch unread notifications
$notification_query = $conn->prepare("SELECT id, title, message, status, notification_time FROM notifications WHERE user_role = ? AND status = 'unread' ORDER BY notification_time DESC");
$notification_query->bind_param('s', $user_role);
$notification_query->execute();
$notification_result = $notification_query->get_result();
$notifications = [];
while ($notification_row = $notification_result->fetch_assoc()) {
    $notifications[] = $notification_row;
}

// Fetch the full notification message if an ID is provided
$full_notification = null;
$notification_title = null;
if (isset($_GET['notification_id'])) {
    $notification_id = $_GET['notification_id'];
    $full_query = $conn->prepare("SELECT title, message FROM notifications WHERE id = ? AND user_role = ?");
    $full_query->bind_param('is', $notification_id, $user_role);
    $full_query->execute();
    $full_result = $full_query->get_result();
    if ($row = $full_result->fetch_assoc()) {
        $notification_title = $row['title'];
        $full_notification = $row['message'];
        // Optionally, mark this notification as read
        $update_query = $conn->prepare("UPDATE notifications SET status = 'read' WHERE id = ? AND user_role = ?");
        $update_query->bind_param('is', $notification_id, $user_role);
        $update_query->execute();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>LeSAS | Notifications</title>
    <link rel="shortcut icon" href="dist/img/favicon.ico">
    <link href="vendors/jquery-toggles/css/toggles.css" rel="stylesheet" type="text/css">
    <link href="vendors/jquery-toggles/css/themes/toggles-light.css" rel="stylesheet" type="text/css">
    <link href="dist/css/style.css" rel="stylesheet" type="text/css">
    <style>
        .notification-container {
            border: 1.5px solid #1dbf45;
            padding: 15px;
            margin-top: 20px;
            display: flex;
        }
        .notification-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .notification-header p {
            margin: 0;
        }
        .notification-list {
            width: 30%;
            border-right: 1px solid #1dbf45;
            padding-right: 10px;
            overflow-y: auto;
        }
        .notification-content {
            width: 70%;
            padding-left: 10px;
        }
        .notification-list a {
            display: block;
            padding: 5px;
            border-bottom: 1px solid #808080;
            text-decoration: none;
            color: #000;
        }
        .notification-list a:hover {
            background-color: #f5f5f5;
        }
        .notification-list .no-notification {
            padding: 10px;
            color: #888;
        }
        .notification-content {
            border-left: 1px solid #1dbf45;
            padding: 10px;
        }
        .notification-title {
            font-weight: bold;
            border-bottom: 3px solid #1dbf45;
            padding: 1px;
        }
        .notification-message {
            padding: 10px;
        }
    </style>
</head>
<body>

<!-- HK Wrapper -->
<div class="hk-wrapper hk-vertical-nav">

    <!-- Top Navbar -->
    <?php include_once('includes/navbar.php'); ?>
    <?php include_once('includes/sidebar.php'); ?>
    <div id="hk_nav_backdrop" class="hk-nav-backdrop"></div>
    <!-- /Vertical Nav -->

    <!-- Main Content -->
    <div class="hk-pg-wrapper">
        <!-- Breadcrumb -->
        <nav class="hk-breadcrumb" aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-light bg-transparent">
                <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Notifications</li>
            </ol>
        </nav>
        <!-- /Breadcrumb -->

        <div class="container">
            <div class="notification-header">
                <h3>Notifications</h3> <br>
                <p><strong>Username:</strong> <?php echo htmlspecialchars($user_info['username']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($user_info['email']); ?></p>
                <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($user_info['phone_number']); ?></p>
            </div>

            <div class="notification-container">
                <div class="notification-list">
                    <div class="notification-title">
                        Title
                    </div>
                    <?php if (!empty($notifications)): ?>
                        <?php foreach ($notifications as $notification): ?>
                            <a href="?notification_id=<?php echo htmlspecialchars($notification['id']); ?>">
                                <?php echo htmlspecialchars(substr($notification['title'], 0, 20)) . (strlen($notification['title']) > 20 ? '...' : ''); ?>
                            </a>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="no-notification">No new notifications</p>
                    <?php endif; ?>
                </div>
                <div class="notification-content">
                    <div class="notification-title">
                        Notification
                    </div>
                    <?php if ($full_notification): ?>
                        <div class="notification-message">
                            <p><?php echo htmlspecialchars($full_notification); ?></p>
                        </div>
                    <?php else: ?>
                        <p>Select a notification to view details</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>
    <!-- /Main Content -->
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
<script src="dist/js/validation-data.js"></script>
<script>
        var inactiveTimeout = <?php echo 300; ?>;
        var idleTimer;

        function resetIdleTimer() {
            clearTimeout(idleTimer);
            idleTimer = setTimeout(logoutUser, inactiveTimeout * 1000);
        }

        function logoutUser() {
            window.location.href = 'auto_logout.php'; 
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
