<?php
// Start the session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
    include('includes/config.php');
}

if (strlen($_SESSION['user_id']) == 0) {
    header('location: logout.php');
    exit();
} else {
    // Initialize alert message variables
    $alertMessage = '';
    $alertType = '';

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (isset($_GET['id'])) {
        // Decode the course name from the URL
        $course_name_encoded = base64_decode($_GET['id']);

        // Fetch course details
        $query = "SELECT * FROM courses WHERE course_name = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $course_name_encoded);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $course = $result->fetch_assoc();
        } else {
            $alertMessage = 'No course found.';
            $alertType = 'danger';
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Get updated course details from the form
            $updated_course_name = $conn->real_escape_string($_POST['course_name']);
            $updated_department_id = $conn->real_escape_string($_POST['department_id']);

            // Update the course in the database
            $update_query = "UPDATE courses SET course_name = ?, department_id = ? WHERE id = ?";
            $update_stmt = $conn->prepare($update_query);
            $update_stmt->bind_param("ssi", $updated_course_name, $updated_department_id, $course['id']);

            if ($update_stmt->execute()) {
                $_SESSION['success'] = 'Course updated successfully.';
                header('location: manage_courses.php');
                exit();
            } else {
                $alertMessage = 'Failed to update course.';
                $alertType = 'danger';
            }
        }
    } else {
        $alertMessage = 'No course selected.';
        $alertType = 'warning';
    }

    // Fetch departments for the dropdown
    $dept_query = "SELECT id, name FROM department";
    $dept_result = $conn->query($dept_query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LeSAS | Edit Course</title>
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
                <li class="breadcrumb-item active" aria-current="page">Edit Course</li>
            </ol>
        </nav>
        <!-- /Breadcrumb -->

        <!-- Container -->
        <div class="container">
            <!-- Title -->
            <div class="hk-pg-header">
                <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="edit"></i></span></span>Edit Course</h4>
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
                                <form method="post" action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $_GET['id']; ?>">
                                    <h4>Edit Course Details</h4>

                                    <div class="form-row">
                                        <div class="col-md-6 mb-10">
                                            <label for="course_name">Course Name</label>
                                            <input type="text" class="form-control" id="course_name" name="course_name" value="<?php echo htmlspecialchars($course['course_name']); ?>" required>
                                            <div class="invalid-feedback">Please provide a valid course name.</div>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="col-md-6 mb-10">
                                            <label for="department_id">Department</label>
                                            <select class="form-control" id="department_id" name="department_id" required>
                                                <option value="">Select department</option>
                                                <?php
                                                if ($dept_result->num_rows > 0) {
                                                    while ($row = $dept_result->fetch_assoc()) {
                                                        $selected = ($row['id'] == $course['department_id']) ? 'selected' : '';
                                                        echo "<option value='" . $row['id'] . "' $selected>" . $row['name'] . "</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <div class="invalid-feedback">Please select a department.</div>
                                        </div>
                                    </div>

                                    <button class="btn btn-primary" type="submit">Save Changes</button>
                                    <a href="manage_courses.php" class="btn btn-secondary">Back to Course List</a>
                                    <a href="add_course.php" class="btn btn-primary">Add New Course</a>

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

</body>
</html>

<?php
    $conn->close();
}
?>
