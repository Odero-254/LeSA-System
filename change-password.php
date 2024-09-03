<?php
// Check if session is not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('includes/config.php');

if (strlen($_SESSION['user_id']) == 0) {
    header('location: logout.php');
    exit();
} else {
    // Update last activity time to extend session
    $_SESSION['last_active_time'] = time();

    // Initialize alert message variables
    $alertMessage = '';
    $alertType = '';

    // Change password code
    if (isset($_POST['submit'])) {
        $user_id = $_SESSION['user_id'];
        $current_password = md5($_POST['currentpassword']);
        $new_password = md5($_POST['newpassword']);
        $confirm_password = md5($_POST['confirmpassword']);

        // Check current password
        $query = mysqli_query($conn, "SELECT ID FROM users WHERE ID='$user_id' AND Password='$current_password'");
        $row = mysqli_fetch_array($query);

        if ($row > 0) {
            if ($new_password == $confirm_password) {
                // Update password
                $ret = mysqli_query($conn, "UPDATE users SET Password='$new_password' WHERE ID='$user_id'");
                if ($ret) {
                    $alertMessage = 'Password changed successfully.';
                    $alertType = 'success';
                } else {
                    $alertMessage = 'Error changing password.';
                    $alertType = 'danger';
                }
            } else {
                $alertMessage = 'New Password and Confirm Password do not match.';
                $alertType = 'warning';
            }
        } else {
            $alertMessage = 'Wrong Current Password. Please try again!';
            $alertType = 'danger';
        }
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Change Password</title>
    <link rel="shortcut icon" href="dist/img/favicon.ico">
    <link href="vendors/jquery-toggles/css/toggles.css" rel="stylesheet" type="text/css">
    <link href="vendors/jquery-toggles/css/themes/toggles-light.css" rel="stylesheet" type="text/css">
    <link href="dist/css/style.css" rel="stylesheet" type="text/css">
    <script type="text/javascript">
        function checkpass() {
            if (document.changepassword.newpassword.value != document.changepassword.confirmpassword.value) {
                document.getElementById('passwordAlert').innerHTML = 'New Password and Confirm Password fields do not match.';
                document.getElementById('passwordAlert').className = 'alert alert-warning alert-dismissible fade show';
                document.getElementById('passwordAlert').style.display = 'block';
                document.changepassword.confirmpassword.focus();
                return false;
            }
            return true;
        }
    </script>
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
                    <li class="breadcrumb-item active" aria-current="page">Settings</li>
                </ol>
            </nav>
            <!-- /Breadcrumb -->

            <!-- Container -->
            <div class="container">
                <!-- Title -->
                <div class="hk-pg-header">
                    <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="external-link"></i></span></span>Change Your Password</h4>
                </div>
                <!-- /Title -->

                <!-- Alert Messages -->
                <?php if ($alertMessage != ''): ?>
                    <div id="passwordAlert" class="alert alert-<?php echo $alertType; ?> alert-dismissible fade show" role="alert" style="display: block;">
                        <?php echo $alertMessage; ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>
                <!-- /Alert Messages -->

                <!-- Row -->
                <div class="row">
                    <div class="col-xl-12">
                        <section class="hk-sec-wrapper">
                            <div class="row">
                                <div class="col-sm">
                                    <form class="needs-validation" method="post" name="changepassword" novalidate onsubmit="return checkpass();">
                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label for="currentpassword">Current Password</label>
                                                <input type="password" class="form-control" id="currentpassword" placeholder="Current Password" name="currentpassword" required>
                                                <div class="invalid-feedback">Please provide your current password.</div>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label for="newpassword">New Password</label>
                                                <input type="password" class="form-control" id="newpassword" placeholder="New Password" name="newpassword" required>
                                                <div class="invalid-feedback">Please provide a new password.</div>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label for="confirmpassword">Confirm Password</label>
                                                <input type="password" class="form-control" id="confirmpassword" placeholder="Confirm New Password" name="confirmpassword" required>
                                                <div class="invalid-feedback">Please confirm the new password.</div>
                                            </div>
                                        </div>
                                         
                                        <button class="btn btn-primary" type="submit" name="submit">Change</button>
                                    </form>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
            <!-- /Container -->
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
<?php } ?>
