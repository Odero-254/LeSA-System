<?php
// Start the session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
    include('includes/config.php');
}


// Check if user is logged in
if (strlen($_SESSION['user_id']) == 0) {
    header('location: logout.php');
    exit();
} else {
    // Update last activity time to extend session
    $_SESSION['last_active_time'] = time();

    // Initialize alert message variables
    $alertMessage = '';
    $alertType = '';

    // Update Profile Code
    if (isset($_POST['update_profile'])) {
        $user_id = $_SESSION['user_id'];
        $email = $_POST['emailid'];
        $phone_number = $_POST['mobilenumber'];

        $query = mysqli_query($conn, "UPDATE users SET phone_number='$phone_number', email='$email' WHERE id='$user_id'");

        if ($query) {
            $alertMessage = 'User details updated successfully.';
            $alertType = 'success';
            echo "<script>
                    setTimeout(function() {
                        window.location.href='settings.php';
                    }, 2000);
                </script>";
        } else {
            $alertMessage = 'Error updating user details: ' . mysqli_error($conn);
            $alertType = 'danger';
        }
    }

    // Change Password Code
    if (isset($_POST['change_password'])) {
        $user_id = $_SESSION['user_id'];
        $current_password = md5($_POST['currentpassword']);
        $new_password = md5($_POST['newpassword']);
        $confirm_password = md5($_POST['confirmpassword']);

        $query = mysqli_query($conn, "SELECT ID FROM users WHERE ID='$user_id' AND Password='$current_password'");
        $row = mysqli_fetch_array($query);

        if ($row > 0) {
            if ($new_password == $confirm_password) {
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
    <title>User Settings</title>
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
                    <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="settings"></i></span></span>Settings</h4>
                </div>
                <!-- /Title -->

                <!-- Alert Messages -->
                <?php if ($alertMessage != ''): ?>
                    <div class="alert alert-<?php echo $alertType; ?> alert-dismissible fade show" role="alert">
                        <?php echo $alertMessage; ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>
                <!-- /Alert Messages -->

                <!-- Row -->
                <div class="row">
                    <div class="col-xl-6">
                        <section class="hk-sec-wrapper">
                            <h5 class="hk-sec-title">Update Profile</h5>
                            <div class="row">
                                <div class="col-sm">
                                    <form class="needs-validation" method="post" novalidate>
                                        <?php
                                        $user_id = $_SESSION['user_id'];
                                        $query = mysqli_query($conn, "SELECT * FROM users WHERE id='$user_id'");
                                        while ($row = mysqli_fetch_array($query)) {
                                            ?>
                                            <div class="form-row">
                                                <div class="col-md-12 mb-10">
                                                    <label for="validationCustom03">Name (you cannot change this field)</label>
                                                    <input type="text" class="form-control" id="validationCustom03" value="<?php echo $row['username']; ?>" name="username" readonly>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-md-12 mb-10">
                                                    <label for="validationCustom03">Email Address*</label>
                                                    <input type="email" class="form-control" id="validationCustom03" value="<?php echo $row['email']; ?>" name="emailid" required>
                                                    <div class="invalid-feedback">Please provide a valid Email id.</div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-md-12 mb-10">
                                                    <label for="validationCustom03">Phone Number*</label>
                                                    <input type="text" class="form-control" id="validationCustom03" value="<?php echo $row['phone_number']; ?>" name="mobilenumber" required>
                                                    <div class="invalid-feedback">Please provide a valid phone number.</div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <button class="btn btn-primary" type="submit" name="update_profile">Update Profile</button>
                                    </form>
                                </div>
                            </div>
                        </section>
                    </div>

                    <div class="col-xl-6">
                        <section class="hk-sec-wrapper">
                            <h5 class="hk-sec-title">Change Password</h5>
                            <div class="row">
                                <div class="col-sm">
                                    <form class="needs-validation" method="post" onsubmit="return checkpass();" name="changepassword" novalidate>
                                        <div id="passwordAlert" style="display:none;"></div>
                                        <div class="form-row">
                                            <div class="col-md-12 mb-10">
                                                <label for="validationCustom03">Current Password*</label>
                                                <input type="password" class="form-control" id="validationCustom03" name="currentpassword" required>
                                                <div class="invalid-feedback">Please provide your current password.</div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-12 mb-10">
                                                <label for="validationCustom03">New Password*</label>
                                                <input type="password" class="form-control" id="validationCustom03" name="newpassword" required>
                                                <div class="invalid-feedback">Please provide a new password.</div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-12 mb-10">
                                                <label for="validationCustom03">Confirm Password*</label>
                                                <input type="password" class="form-control" id="validationCustom03" name="confirmpassword" required>
                                                <div class="invalid-feedback">Please confirm your new password.</div>
                                            </div>
                                        </div>
                                        <button class="btn btn-primary" type="submit" name="change_password">Change Password</button>
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
    <!-- /HK Wrapper -->

    <script src="vendors/jquery/dist/jquery.min.js"></script>
    <script src="vendors/popper.js/dist/umd/popper.min.js"></script>
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="vendors/jasny-bootstrap/dist/js/jasny-bootstrap.min.js"></script>
    <script src="dist/js/jquery.slimscroll.js"></script>
    <script src="dist/js/dropdown-bootstrap-extended.js"></script>
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

            // Set up event listeners to reset idle timer on user activity
            document.addEventListener('mousemove', resetIdleTimer);
            document.addEventListener('mousedown', resetIdleTimer);
            document.addEventListener('keypress', resetIdleTimer);
            document.addEventListener('scroll', resetIdleTimer);
            }
            // Initialize the idle timer on page load
            resetIdleTimer();
    </script>
</body>
</html>
<?php } ?>
