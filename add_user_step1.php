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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <link rel="shortcut icon" href="dist/img/favicon.ico">
    <link href="vendors/jquery-toggles/css/toggles.css" rel="stylesheet" type="text/css">
    <link href="vendors/jquery-toggles/css/themes/toggles-light.css" rel="stylesheet" type="text/css">
    <link href="dist/css/style.css" rel="stylesheet" type="text/css">
</head>
<body>

<!-- HK Wrapper -->
<div class="hk-wrapper hk-vertical-nav">

<!-- Top Navbar -->
<?php include_once('includes/navbar.php');
include_once('includes/sidebar.php');
?>
       


        <div id="hk_nav_backdrop" class="hk-nav-backdrop"></div>
        <!-- /Vertical Nav -->



        <!-- Main Content -->
        <div class="hk-pg-wrapper">
            <!-- Breadcrumb -->
            <nav class="hk-breadcrumb" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-light bg-transparent">
                    <li class="breadcrumb-item"><a href="dashboard_admin.php">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add user</li>
                </ol>
            </nav>
            <!-- /Breadcrumb -->

            <!-- Container -->
            <div class="container">
                <!-- Title -->
                <div class="hk-pg-header">
                    <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="external-link"></i></span></span>Add User</h4>
                </div>
                <!-- /Title -->

                <!-- Row -->
                <div class="row">
                    <div class="col-xl-12">
<section class="hk-sec-wrapper">

<div class="row">
<div class="col-sm">


<form action="add_user_step2" class="needs-validation" method="post" novalidate>
    <h3>Personal Details</h3>
    <div class="form-row">
        <div class="col-md-6 mb-10">
            <label for="validationCustom03">User Name</label>
             <input type="text" class="form-control" id="validationCustom03" placeholder="enter the user's name" name="username" required>
            <div class="invalid-feedback">Please provide a valid user name.</div>
        </div>
    </div>
    
    <div class="form-row">
        <div class="col-md-6 mb-10">
            <label for="validationCustom03">Email Address</label>
                <input type="email" class="form-control" id="validationCustom03" placeholder="enter email address" name="emailaddress" required>
            <div class="invalid-feedback">Please provide a valid email address.</div>
        </div>
    </div>
        
    <div class="form-row">
        <div class="col-md-6 mb-10">
            <label for="validationCustom03">Phone Number</label>
            <input type="text" class="form-control" id="validationCustom03" placeholder="start with +254" name="phoneNumber" pattern="\+254\d{9}" title="Phone number must start with +254 followed by 9 digits" required>
            <div class="invalid-feedback">Phone number must start with +254 and cannot exceed 12 values</div>
        </div>
    </div>

    <button class="btn btn-primary" type="submit" name="submit">Next</button>
</form>
</div>
</div>
</section>
                     
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