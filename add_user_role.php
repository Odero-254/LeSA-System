<?php
// Check if session is not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once 'includes/config.php';

// Initialize alert message variables
$alertMessage = '';
$alertType = '';

if (!isset($_SESSION['form1'])) {
    header("Location: add_user.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['form2'])) {
    $user_role = $_POST['user_role'];
    $department_id = $_POST['department_id'];
    $_SESSION['form2'] = $_POST;

    if ($user_role == 'Class Representative') {
        $_SESSION['error'] = "Only HODs can add Class Representative! Kindly select another role or exit or message the respective HOD for the same";
        header("Location: add_user_role.php");
        exit();
    }

    // Update last activity time to extend session
    $_SESSION['last_active_time'] = time();

    if (in_array($user_role, ['HOD', 'Lecturer'])) {
        header("Location: add_user_subjects.php");
    } else {
        header("Location: add_user_final.php");
    }
    exit();
}

// Fetch departments
$departments = [];
$result = $conn->query("SELECT id, name FROM department");
while ($row = $result->fetch_assoc()) {
    $departments[] = $row;
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
            <li class="breadcrumb-item active" aria-current="page">Add User / Role and Department </li>
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
    <form method="post" action="add_user_role.php">
    <h3>Role and Department</h3>
    <div class="form-row">
        <div class="col-md-6-10">
            <label for="validationCustom03">User Role* </label>
                <select type="text" class="form-control" id="validationCustom03" placeholder="select user role" name="user_role" required>
                    <option value="">Select user Role</option>
                    <option value="Principal">Principal</option>
                    <option value="Deputy Principal">Deputy Principal</option>
                    <option value="HOD">HOD</option>
                    <option value="Lecturer">Lecturer</option>
                    <option value="Class Representative">Class Representative</option>
                </select><br>
            <div class="invalid-feedback">username cannot be blank.</div>
        </div>
    </div>

    <div class="form-row">
        <div class="col-md-6 mb-10">
            <label for="validationCustom03">Department*</label>
                <select class="form-control" id="validationCustom03" name="department_id" required>
                <option value="">Select department</option>
                    <?php foreach ($departments as $department) { ?>
                        <option value="<?php echo $department['id']; ?>"><?php echo $department['name']; ?></option>
                    <?php } ?>
                </select>
            <div class="invalid-feedback">Please select the department name.</div>
        </div>
    </div>
        <input type="hidden" name="form2" value="true">
        <a href="add_user.php" class="btn btn-secondary">Back</a>
        <button class="btn btn-primary" type="submit" name="add user">Next</button>
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
<?php
    // Close database connection
    $conn->close();
?>
