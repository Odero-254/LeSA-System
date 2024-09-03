<?php
// Check if session is not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once 'includes/config.php';

// Initialize alert message variables
$alertMessage = '';
$alertType = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['form1'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];

    // Validate phone number
    if (!preg_match('/^\+254[0-9]{9}$/', $phone_number)) {
        $_SESSION['error'] = "Invalid phone number format.";
        header("Location: add_user.php");
        exit();
    }
    
    // Update last activity time to extend session
    $_SESSION['last_active_time'] = time();

    // Check for duplicate entries
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ? OR phone_number = ?");
    if (!$stmt) {
        $_SESSION['error'] = "Prepare statement failed: " . $conn->error;
        header("Location: add_user.php");
        exit();
    }

    $stmt->bind_param("sss", $username, $email, $phone_number);
    if (!$stmt->execute()) {
        $_SESSION['error'] = "Execute statement failed: " . $stmt->error;
        header("Location: add_user.php");
        exit();
    }

    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $_SESSION['error'] = "Username, Email or Phone Number already exists.";
        header("Location: add_user.php");
        exit();
    }

    $_SESSION['form1'] = $_POST;
    header("Location: add_user_role.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>LeSA | Add User</title>
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
            <li class="breadcrumb-item"><a href="dashboard_admin.php">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add User / Personal details </li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container">
        <!-- Title -->
        <div class="hk-pg-header">
            <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="external-link"></i></span></span>Add user</h4>
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
                            <?php if (isset($_SESSION['error'])) { echo '<p style="color:red;">'.$_SESSION['error'].'</p>'; unset($_SESSION['error']); } ?>
                            <form method="post" action="add_user.php">
                                <h3>Personal Details</h3>
                                <div class="form-row">
                                    <div class="col-md-6-10">
                                        <label for="validationCustom03">Enter User name* </label>
                                        <input type="text" class="form-control" id="validationCustom03" placeholder="Enter username" name="username" required>
                                        <div class="invalid-feedback">username cannot be blank.</div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-md-6-10">
                                        <label for="validationCustom03">Email Address* </label>
                                        <input type="email" class="form-control" id="validationCustom03" placeholder="Enter email address" name="email" required>
                                        <div class="invalid-feedback">Enter a valid email address</div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-md-6-10">
                                        <label for="validationCustom03">Phone Number* </label>
                                        <input type="text" class="form-control" id="validationCustom03" placeholder="Enter phone number" name="phone_number" required>
                                        <div class="invalid-feedback">Enter a valid phone number</div>
                                    </div>
                                </div>

                                <input type="hidden" name="form1" value="true"><br>
                                <a href="dashboard_admin.php" class="btn btn-secondary">Back</a>
                                <button class="btn btn-primary" type="submit" name="add_user">Next</button>
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
            window.location.href = 'logout.php'; 
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
// Close database connection
$conn->close();
?>
