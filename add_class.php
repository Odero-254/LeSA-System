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

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // If form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_class'])) {
        $class_name = $conn->real_escape_string($_POST['class_name']);
        $course_id = $conn->real_escape_string($_POST['course_id']);
        $level_id = $conn->real_escape_string($_POST['level_id']);
        $department_id = $conn->real_escape_string($_POST['department_id']);

        // Validate inputs
        if (empty($class_name) || empty($course_id) || empty($level_id) || empty($department_id)) {
            $alertMessage = 'Please fill all fields.';
            $alertType = 'warning';
        } else {
            // Check if the record already exists in the database
            $check_query = "SELECT * FROM classes WHERE class_name='$class_name' AND course_id='$course_id' AND level_id='$level_id' AND department_id='$department_id'";
            $check_result = $conn->query($check_query);

            if ($check_result->num_rows > 0) {
                // Record already exists
                $alertMessage = 'Class already exists.';
                $alertType = 'info';
            } else {
                // Insert into classes table
                $insert_query = "INSERT INTO classes (class_name, course_id, level_id, department_id) VALUES ('$class_name', '$course_id', '$level_id', '$department_id')";
                
                if ($conn->query($insert_query) === TRUE) {
                    $alertMessage = 'Class added successfully.';
                    $alertType = 'success';
                } else {
                    $alertMessage = 'Error adding class: ' . $conn->error;
                    $alertType = 'danger';
                }
            }
        }
    }

    // Fetch courses from courses table
    $courses_query = "SELECT * FROM courses";
    $courses_result = $conn->query($courses_query);

    // Fetch levels from levels table
    $levels_query = "SELECT * FROM levels";
    $levels_result = $conn->query($levels_query);

    // Fetch departments from department table
    $departments_query = "SELECT * FROM department";
    $departments_result = $conn->query($departments_query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>LeSAS | Add Class Form</title>
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
                <li class="breadcrumb-item active" aria-current="page">Add Class</li>
            </ol>
        </nav>
        <!-- /Breadcrumb -->

        <!-- Container -->
        <div class="container">
            <!-- Title -->
            <div class="hk-pg-header">
                <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="external-link"></i></span></span>Add Class</h4>
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
                                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                    <h4>Enter Class Details</h4>

                                    <div class="form-row">
                                        <div class="col-md-6 mb-10">
                                            <label for="validationCustom03">Enter Class Name*</label>
                                            <input type="text" class="form-control" id="validationCustom03" placeholder="Enter the class name" name="class_name" required>
                                            <div class="invalid-feedback">Please provide a valid class name.</div>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="col-md-6 mb-10">
                                            <label for="validationCustom03">Select Course Name*</label>
                                            <select class="form-control" id="validationCustom03" name="course_id" required>
                                                <option value="">Select course name</option>
                                                <?php
                                                // Populate courses dropdown
                                                if ($courses_result->num_rows > 0) {
                                                    while($row = $courses_result->fetch_assoc()) {
                                                        echo "<option value='" . $row['id'] . "'>" . $row['course_name'] . "</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <div class="invalid-feedback">Please select the course name.</div>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="col-md-6 mb-10">
                                            <label for="validationCustom03">Course Level*</label>
                                            <select class="form-control" id="validationCustom03" name="level_id" required>
                                                <option value="">Select course level</option>
                                                <?php
                                                // Populate levels dropdown
                                                if ($levels_result->num_rows > 0) {
                                                    while($row = $levels_result->fetch_assoc()) {
                                                        echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <div class="invalid-feedback">Please select the course level.</div>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="col-md-6 mb-10">
                                            <label for="validationCustom03">Department*</label>
                                            <select class="form-control" id="validationCustom03" name="department_id" required>
                                                <option value="">Select department</option>
                                                <?php
                                                // Populate departments dropdown
                                                if ($departments_result->num_rows > 0) {
                                                    while($row = $departments_result->fetch_assoc()) {
                                                        echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <div class="invalid-feedback">Please select the department.</div>
                                        </div>
                                    </div>

                                    <button class="btn btn-primary" type="submit" name="add_class">Add Class</button>
                                    <a href="dashboard_admin.php" class="btn btn-secondary">Back</a>

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
        window.location.href = 'auto_logout.php'; // Redirect to auto_logout page or login page
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
}
?>
