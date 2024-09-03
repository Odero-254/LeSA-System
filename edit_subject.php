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

    // Initialize subject variable
    $subject = null;

    // Get subject ID from query string
    if (isset($_GET['id']) && !empty(trim($_GET['id']))) {
        $subject_id = intval($_GET['id']);
        
        // Fetch subject details
        $query = "SELECT * FROM subjects WHERE id = ?";
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param("i", $subject_id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows == 1) {
                $subject = $result->fetch_assoc();
            } else {
                $alertMessage = 'Subject not found.';
                $alertType = 'danger';
            }
            $stmt->close();
        }
    } else {
        $alertMessage = 'Invalid request.';
        $alertType = 'danger';
    }

    // If form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_subject'])) {
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
            // Update subject in the database
            $update_query = "UPDATE subjects SET subject_name = ?, course_id = ?, level_id = ?, class_id = ?, department_id = ?, qualifications = ? WHERE id = ?";
            if ($stmt = $conn->prepare($update_query)) {
                $stmt->bind_param("siiiiii", $subject_name, $course_id, $level_id, $class_id, $department_id, $qualifications, $subject_id);
                if ($stmt->execute()) {
                    $alertMessage = 'Subject updated successfully.';
                    $alertType = 'success';
                } else {
                    $alertMessage = 'Error updating subject: ' . $conn->error;
                    $alertType = 'danger';
                }
                $stmt->close();
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
    <title>LeSAS | Edit Subject</title>
    <link rel="shortcut icon" href="dist/img/favicon.ico">
    <link href="vendors/jquery-toggles/css/toggles.css" rel="stylesheet" type="text/css">
    <link href="vendors/jquery-toggles/css/themes/toggles-light.css" rel="stylesheet" type="text/css">
    <link href="dist/css/style.css" rel="stylesheet" type="text/css">
    <style>
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

    <!-- Main Content -->
    <div class="hk-pg-wrapper">
        <nav class="hk-breadcrumb" aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-light bg-transparent">
                <li class="breadcrumb-item"><a href="dashboard_admin.php">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Subject</li>
            </ol>
        </nav>

        <div class="container">
            <div class="hk-pg-header">
                <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="edit-2"></i></span></span>Edit Subject</h4>
            </div>

            <?php if ($alertMessage != ''): ?>
                <div class="alert alert-<?php echo $alertType; ?> alert-dismissible fade show" role="alert">
                    <?php echo $alertMessage; ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>

            <div class="row">
                <div class="col-xl-12">
                    <section class="hk-sec-wrapper">
                        <div class="row">
                            <div class="col-sm">
                            <?php if ($subject): ?>
                            <form method="post" action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $_GET['id']; ?>">
                                    <h3>Edit Subject Details</h3>

                                    <div class="form-row">
                                        <div class="col-md-6 mb-10">
                                            <label for="validationCustom03">Subject Name</label>
                                            <input type="text" class="form-control" id="validationCustom03" placeholder="Enter the subject name" name="subject_name" value="<?php echo $subject['subject_name']; ?>" required>
                                            <div class="invalid-feedback">Please provide a valid subject name.</div>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="col-md-6 mb-10">
                                            <label for="validationCustom03">Course</label>
                                            <select class="form-control" id="course_id" name="course_id" required>
                                                <option value="">Select course</option>
                                                <?php
                                                if ($courses_result->num_rows > 0) {
                                                    while ($row = $courses_result->fetch_assoc()) {
                                                        echo "<option value='" . $row['id'] . "' " . ($row['id'] == $subject['course_id'] ? 'selected' : '') . ">" . $row['course_name'] . "</option>";
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
                                                if ($levels_result->num_rows > 0) {
                                                    while ($row = $levels_result->fetch_assoc()) {
                                                        echo "<option value='" . $row['id'] . "' " . ($row['id'] == $subject['level_id'] ? 'selected' : '') . ">" . $row['name'] . "</option>";
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
                                                <?php
                                                // Add logic to populate class dropdown based on course and level
                                                ?>
                                            </select>
                                            <div class="invalid-feedback">Please select the class.</div>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="col-md-6 mb-10">
                                            <label for="validationCustom03">Department</label>
                                            <select class="form-control" id="department_id" name="department_id" required>
                                                <option value="">Select department</option>
                                                <?php
                                                if ($departments_result->num_rows > 0) {
                                                    while ($row = $departments_result->fetch_assoc()) {
                                                        echo "<option value='" . $row['id'] . "' " . ($row['id'] == $subject['department_id'] ? 'selected' : '') . ">" . $row['department_name'] . "</option>";
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
                                            <input type="text" class="form-control" id="validationCustom03" placeholder="Enter the required qualifications" name="qualifications" value="<?php echo $subject['qualifications']; ?>" required>
                                            <div class="invalid-feedback">Please provide valid qualifications.</div>
                                        </div>
                                    </div>

                                    <button class="btn btn-primary" type="submit" name="edit_subject">Update Subject</button>
                                    <a href="manage_subjects.php" class="btn btn-secondary">Back</a>
                                </form>
                            <?php else: ?>
                                <p>No subject details found.</p>
                            <?php endif; ?>
                            </div>
                        </div>
                    </section>
                </div>
            </div>

        </div>

    </div>
    <!-- /Main Content -->

</div>
<!-- /HK Wrapper -->

<!-- JavaScript -->
<script src="vendors/popper.js/dist/umd/popper.min.js"></script>
<script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="dist/js/jquery.slimscroll.js"></script>
<script src="dist/js/dropdown-bootstrap-extended.js"></script>
<script src="dist/js/feather.min.js"></script>
<script src="dist/js/init.js"></script>
<script src="vendors/jquery-toggles/toggles.min.js"></script>
<script src="dist/js/toggle-data.js"></script>
</body>
</html>
<?php } ?>
