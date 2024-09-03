<?php
// Check if session is not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once 'includes/config.php';

// Initialize alert message variables
$alertMessage = '';
$alertType = '';


if (!isset($_SESSION['form1']) || !isset($_SESSION['form2'])) {
    header("Location: add_user.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['form3'])) {
    // Store form data in the session
    $_SESSION['form3'] = $_POST;
    header("Location: add_user_final.php");
    exit();
}
// Update last activity time to extend session
$_SESSION['last_active_time'] = time();

// Fetch subjects and qualifications from the database
$subjects = [];
$result = $conn->query("SELECT id, subject_name, qualifications FROM subjects");
while ($row = $result->fetch_assoc()) {
    $subjects[] = $row;
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
            <li class="breadcrumb-item active" aria-current="page">Add User / Subject Qualifications</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container">
        <!-- Title -->
        <div class="hk-pg-header">
            <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="external-link"></i></span></span>Select qualifications</h4>
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
    <form method="post" action="add_user_subjects.php">
    <h3>Subject Qualifications</h3> <br>
        <?php foreach ($subjects as $subject) { ?>
            <input type="checkbox" name="subject_ids[]" value="<?php echo $subject['id']; ?>" data-name="<?php echo htmlspecialchars($subject['subject_name']); ?>" data-qual="<?php echo htmlspecialchars($subject['qualifications']); ?>"> 
            <?php echo htmlspecialchars($subject['subject_name']); ?> (Qualifications: <?php echo htmlspecialchars($subject['qualifications']); ?>)<br>
        <?php } ?>
        <input type="hidden" name="form3" value="true"><br>
        <a href="add_user_role.php" class="btn btn-secondary">Back</a>
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
        // Update hidden fields with selected subject names, IDs, and qualifications
        document.querySelector('form').addEventListener('submit', function() {
            var selectedSubjects = document.querySelectorAll('input[name="subject_ids[]"]:checked');
            var subjectIds = [];
            var subjectNames = [];
            var qualifications = [];

            selectedSubjects.forEach(function(subject) {
                subjectIds.push(subject.value);
                subjectNames.push(subject.getAttribute('data-name'));
                qualifications.push(subject.getAttribute('data-qual'));
            });

            // Add hidden fields for subject names, IDs, and qualifications
            var idsField = document.createElement('input');
            idsField.type = 'hidden';
            idsField.name = 'subject_ids';
            idsField.value = subjectIds.join(',');

            var namesField = document.createElement('input');
            namesField.type = 'hidden';
            namesField.name = 'subject_names';
            namesField.value = subjectNames.join(',');

            var qualField = document.createElement('input');
            qualField.type = 'hidden';
            qualField.name = 'qualifications';
            qualField.value = qualifications.join(',');

            this.appendChild(idsField);
            this.appendChild(namesField);
            this.appendChild(qualField);
        });

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
