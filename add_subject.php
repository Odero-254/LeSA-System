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

    // If form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_subject'])) {
        $subject_name = $conn->real_escape_string($_POST['subject_name']);
        $course_id = $conn->real_escape_string($_POST['course_id']);
        $level_id = $conn->real_escape_string($_POST['level_id']);
        $class_id = $conn->real_escape_string($_POST['class_id']);
        $department_id = $conn->real_escape_string($_POST['department_id']);
        $qualifications = $conn->real_escape_string($_POST['qualifications']);

        // Validate inputs
        if (empty($subject_name) || empty($course_id) || empty($level_id) || empty($class_id) || empty($department_id) || empty($qualifications)) {
            $alertMessage = 'Please fill all fields.';
            $alertType = 'warning';
        } else {
            // Insert into subjects table
            $insert_query = "INSERT INTO subjects (subject_name, course_id, level_id, class_id, department_id, qualifications) VALUES ('$subject_name', '$course_id', '$level_id', '$class_id', '$department_id', '$qualifications')";
            
            if ($conn->query($insert_query) === TRUE) {
                $alertMessage = 'Subject added successfully.';
                $alertType = 'success';
            } else {
                $alertMessage = 'Error adding subject: ' . $conn->error;
                $alertType = 'danger';
            }
        }
    }

    // Fetch courses, levels, and departments from respective tables
    $courses_query = "SELECT * FROM courses";
    $courses_result = $conn->query($courses_query);

    $levels_query = "SELECT * FROM levels";
    $levels_result = $conn->query($levels_query);

    $departments_query = "SELECT * FROM department";
    $departments_result = $conn->query($departments_query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>LeSAS | Add Subject Form</title>
    <link rel="shortcut icon" href="dist/img/favicon.ico">
    <link href="vendors/jquery-toggles/css/toggles.css" rel="stylesheet" type="text/css">
    <link href="vendors/jquery-toggles/css/themes/toggles-light.css" rel="stylesheet" type="text/css">
    <link href="dist/css/style.css" rel="stylesheet" type="text/css">
    <style>
        /* Ensure dropdown menu items are visible */
        .form-control {
            color: #000;
        }
        .form-control option {
            color: #000;
        }
    </style>
    <script src="vendors/jquery/dist/jquery.min.js"></script>
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
                <li class="breadcrumb-item active" aria-current="page">Add Subject</li>
            </ol>
        </nav>
        <!-- /Breadcrumb -->

        <!-- Container -->
        <div class="container">
            <!-- Title -->
            <div class="hk-pg-header">
                <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="external-link"></i></span></span>Add Subject</h4>
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
                                    <h3>Enter Subject Details</h3>

                                    <div class="form-row">
                                        <div class="col-md-6 mb-10">
                                            <label for="validationCustom03">Subject Name</label>
                                            <input type="text" class="form-control" id="validationCustom03" placeholder="Enter the subject name" name="subject_name" required>
                                            <div class="invalid-feedback">Please provide a valid subject name.</div>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="col-md-6 mb-10">
                                            <label for="validationCustom03">Course</label>
                                            <select class="form-control" id="course_id" name="course_id" required>
                                                <option value="">Select course</option>
                                                <?php
                                                // Populate courses dropdown
                                                if ($courses_result->num_rows > 0) {
                                                    while($row = $courses_result->fetch_assoc()) {
                                                        echo "<option value='" . $row['id'] . "'>" . $row['course_name'] . "</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <div class="invalid-feedback">Please select the course.</div>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="col-md-6 mb-10">
                                            <label for="validationCustom03">Level</label>
                                            <select class="form-control" id="level_id" name="level_id" required>
                                                <option value="">Select level</option>
                                                <?php
                                                // Populate levels dropdown
                                                if ($levels_result->num_rows > 0) {
                                                    while($row = $levels_result->fetch_assoc()) {
                                                        echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <div class="invalid-feedback">Please select the level.</div>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="col-md-6 mb-10">
                                            <label for="validationCustom03">Class</label>
                                            <select class="form-control" id="class_id" name="class_id" required>
                                                <option value="">Select class</option>
                                                <!-- Options will be populated by JavaScript -->
                                            </select>
                                            <div class="invalid-feedback">Please select the class.</div>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="col-md-6 mb-10">
                                            <label for="validationCustom03">Department</label>
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

                                    <div class="form-row">
                                        <div class="col-md-6 mb-10">
                                            <label for="validationCustom03">Qualifications</label>
                                            <input type="text" class="form-control" id="validationCustom03" placeholder="Enter qualifications" name="qualifications" required>
                                            <div class="invalid-feedback">Please provide qualifications.</div>
                                        </div>
                                    </div>

                                    <button class="btn btn-primary" type="submit" name="add_subject">Add Subject</button>
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
document.addEventListener('DOMContentLoaded', function() {
    // Function to fetch classes based on selected course and level
    function fetchClasses() {
        var course_id = document.querySelector('select[name="course_id"]').value;
        var level_id = document.querySelector('select[name="level_id"]').value;

        if (course_id && level_id) {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'fetch_classes.php?course_id=' + course_id + '&level_id=' + level_id, true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    var classSelect = document.getElementById('class_id');
                    classSelect.innerHTML = '<option value="">Select class</option>'; // Clear existing options
                    response.forEach(function(classObj) {
                        var option = document.createElement('option');
                        option.value = classObj.id;
                        option.textContent = classObj.class_name;
                        classSelect.appendChild(option);
                    });
                }
            };
            xhr.send();
        }
    }

    // Add event listeners to course and level dropdowns
    document.querySelector('select[name="course_id"]').addEventListener('change', fetchClasses);
    document.querySelector('select[name="level_id"]').addEventListener('change', fetchClasses);
});
</script>

</body>
</html>
<?php
    // Close database connection
    $conn->close();
}
?>