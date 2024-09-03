<?php
// Start the session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include('includes/config.php');

// Check for user inactivity and handle it
include('auto_logout.php'); // This checks session timeout and redirects if needed

// Check if the user is logged in
if (empty($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect to login.php if not logged in
    exit();
} else {
    // Update the last activity time to extend the session
    $_SESSION['last_active_time'] = time();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - LeSA Portal</title>
    <link rel="shortcut icon" href="dist/img/favicon.ico">
    <link href="vendors/vectormap/jquery-jvectormap-2.0.3.css" rel="stylesheet" type="text/css" />
    <link href="vendors/jquery-toggles/css/toggles.css" rel="stylesheet" type="text/css">
    <link href="vendors/jquery-toggles/css/themes/toggles-light.css" rel="stylesheet" type="text/css">
    <link href="vendors/jquery-toast-plugin/dist/jquery.toast.min.css" rel="stylesheet" type="text/css">
    <link href="dist/css/style.css" rel="stylesheet" type="text/css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa;
        }
        .container {
            text-align: center;
            position: relative;
            top: 1px;
            left: 70px;
        }
        .logo {
            max-width: 150px;
            margin-bottom: 20px;
        }
        .watermark {
            font-size: 24px;
            color: rgba(108, 117, 125, 0.5); /* Light grey color */
        }
        .alert {
            color: red;
            font-size: 18px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <?php if (isset($_GET['message']) && $_GET['message'] == 'inactive_logout') { ?>
        <div class="alert">
            You have been logged out automatically due to inactivity, please login again to return to the page.
        </div>
    <?php } ?>

    <div class="hk-wrapper hk-vertical-nav">
        <!-- Top Navbar -->
        <?php include_once('includes/navbar.php');
        include_once('includes/sidebar.php'); ?>

        <div id="hk_nav_backdrop" class="hk-nav-backdrop"></div>
        <!-- /Vertical Nav -->
        <!-- Space for sidebar -->
        <div class="sidebar"></div>
        <!-- Space for header -->
        <div class="header"></div>

        <div class="container">
            <img src="dist/img/nyslogo2.png" alt="LeSA Logo" class="logo">
            <div class="watermark">
                Welcome to the LeSA System! <br>
                Our platform enhances your educational experience with tools to update <br>your details, 
                manage account settings, access course information, connect <br>with peers and lecturers, 
                download resources, and receive real-time <br>updates on assignments and exams and much more.<br> 
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="vendors/jquery/dist/jquery.min.js"></script>
    <script src="vendors/popper.js/dist/umd/popper.min.js"></script>
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="dist/js/jquery.slimscroll.js"></script>
    <script src="dist/js/dropdown-bootstrap-extended.js"></script>
    <script src="dist/js/feather.min.js"></script>
    <script src="vendors/jquery-toggles/toggles.min.js"></script>
    <script src="dist/js/toggle-data.js"></script>
    <script src="vendors/waypoints/lib/jquery.waypoints.min.js"></script>
    <script src="vendors/jquery.counterup/jquery.counterup.min.js"></script>
    <script src="vendors/jquery.sparkline/dist/jquery.sparkline.min.js"></script>
    <script src="vendors/vectormap/jquery-jvectormap-2.0.3.min.js"></script>
    <script src="vendors/vectormap/jquery-jvectormap-world-mill-en.js"></script>
    <script src="dist/js/vectormap-data.js"></script>
    <script src="vendors/owl.carousel/dist/owl.carousel.min.js"></script>
    <script src="vendors/jquery-toast-plugin/dist/jquery.toast.min.js"></script>
    <script src="vendors/apexcharts/dist/apexcharts.min.js"></script>
    <script src="dist/js/irregular-data-series.js"></script>
    <script src="dist/js/init.js"></script>

    <script>
    var inactiveTimeout = <?php echo 300; ?>; 
    var idleTimer;

    function resetIdleTimer() {
        clearTimeout(idleTimer);
        idleTimer = setTimeout(logoutUser, inactiveTimeout * 1000);
    }

    function logoutUser() {
        window.location.href = 'auto_logout.php'; // Redirect to auto_logout.php
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
