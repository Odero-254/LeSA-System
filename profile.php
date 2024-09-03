<?php
// Check if session is not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('includes/config.php');

// Check if user is logged in
if (strlen($_SESSION['user_id']) == 0) {
    echo "Session user_id is empty. Redirecting to logout.php...";
    header('location: logout.php');
    exit();
} else {
    // Update last activity time to extend session
    $_SESSION['last_active_time'] = time();
    
    // Initialize alert message variables
    $alertMessage = '';
    $alertType = '';

    if (isset($_POST['update'])) {
        $user_id = $_SESSION['user_id'];
        $email = $_POST['emailid'];
        $phone_number = $_POST['mobilenumber']; 
        
        $query = mysqli_query($conn, "UPDATE users SET phone_number='$phone_number', Email='$email' WHERE id='$user_id'");
        
        if ($query) {
            $alertMessage = 'User details updated successfully.';
            $alertType = 'success';
            // Redirect after successful update to prevent form resubmission
            echo "<script>
                    setTimeout(function() {
                        window.location.href='profile.php';
                    }, 2000);
                </script>";
        } else {
            $alertMessage = 'Error updating user details: ' . mysqli_error($conn);
            $alertType = 'danger';
        }
    }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>User Profile</title>
    <link rel="shortcut icon" href="dist/img/favicon.ico">
    <link href="vendors/jquery-toggles/css/toggles.css" rel="stylesheet" type="text/css">
    <link href="vendors/jquery-toggles/css/themes/toggles-light.css" rel="stylesheet" type="text/css">
    <link href="dist/css/style.css" rel="stylesheet" type="text/css">
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
                    <li class="breadcrumb-item active" aria-current="page">Update profile</li>
                </ol>
            </nav>
            <!-- /Breadcrumb -->

            <!-- Container -->
            <div class="container">
                <!-- Title -->
                <div class="hk-pg-header">
                    <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i
                                    data-feather="external-link"></i></span></span>Update Your Profile</h4>
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
                    <div class="col-xl-12">
                        <section class="hk-sec-wrapper">

                            <div class="row">
                                <div class="col-sm">
                                    <form class="needs-validation" method="post" novalidate>

                                        <?php
                                        // Getting user details
                                        $user_id = $_SESSION['user_id'];
                                        $query = mysqli_query($conn, "SELECT * FROM users WHERE id='$user_id'");
                                        while ($row = mysqli_fetch_array($query)) {
                                            ?>

                                        

                                        <?php if ($row['UpdationDate'] != "") { ?>
                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label for="validationCustom03"> Last Updation Date</label>
                                                <?php echo $row['UpdationDate']; ?>
                                            </div>
                                        </div>
                                        <?php } ?>

                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label for="validationCustom03"> Name</label>
                                                <input type="text" class="form-control" id="validationCustom03"
                                                    value="<?php echo $row['username']; ?>" name="username" readonly>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label for="validationCustom03">Email Address</label>
                                                <input type="text" class="form-control" id="validationCustom03"
                                                    value="<?php echo $row['email']; ?>" name="emailid" required>
                                                <div class="invalid-feedback">Please provide a valid Email id.</div>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label for="validationCustom03"> Phone Number</label>
                                                <input type="character" class="form-control" id="validationCustom03"
                                                    value="<?php echo $row['phone_number']; ?>" name="mobilenumber"
                                                    required>
                                                <div class="invalid-feedback">Please provide a valid phone number.</div>
                                            </div>
                                        </div>

                                        <?php } ?>

                                        <button class="btn btn-primary" type="submit" name="update">Update</button>
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
