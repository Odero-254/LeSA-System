<?php
// Check if session is not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('includes/config.php');

if (strlen($_SESSION['user_id']) == 0) {
    header('location:logout.php');
    exit();
} else {
    // Update last activity time to extend session
    $_SESSION['last_active_time'] = time();

    if (isset($_GET['id'])) {
        $class_name = base64_decode($_GET['id']);

        // Fetch class details
        $stmt = $conn->prepare("SELECT * FROM classes WHERE class_name = ?");
        $stmt->bind_param("s", $class_name);
        $stmt->execute();
        $result = $stmt->get_result();
        $class = $result->fetch_assoc();
        $stmt->close();

        // Handle form submission
        if (isset($_POST['update_class'])) {
            $new_class_name = $_POST['class_name'];
            $course_id = $_POST['course_id'];
            $level_id = $_POST['level_id'];
            $department_id = $_POST['department_id'];

            $stmt = $conn->prepare("UPDATE classes SET class_name = ?, course_id = ?, level_id = ?, department_id = ? WHERE class_name = ?");
            $stmt->bind_param("siiis", $new_class_name, $course_id, $level_id, $department_id, $class_name);

            if ($stmt->execute()) {
                $alert_message = "Class updated successfully!";
                $alert_type = "success";
                // Update class_name in URL for next load
                $class_name = $new_class_name;
            } else {
                $alert_message = "Failed to update class. Please try again.";
                $alert_type = "danger";
            }

            $stmt->close();
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Edit Class</title>
    <link rel="shortcut icon" href="dist/img/favicon.ico">
    <link href="dist/css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
    <!-- HK Wrapper -->
    <div class="hk-wrapper hk-vertical-nav">
        <!-- Top Navbar -->
        <?php include_once('includes/navbar.php'); include_once('includes/sidebar.php'); ?>
        <div id="hk_nav_backdrop" class="hk-nav-backdrop"></div>
        <!-- Main Content -->
        <div class="hk-pg-wrapper">
            <!-- Breadcrumb -->
            <nav class="hk-breadcrumb" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-light bg-transparent">
                    <li class="breadcrumb-item"><a href="home.php">Classes</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
            </nav>
            <!-- Container -->
            <div class="container">
                <!-- Title -->
                <div class="hk-pg-header">
                    <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="edit"></i></span></span>Edit Class</h4>
                </div>
                <!-- Alert Message -->
                <?php if (isset($alert_message)): ?>
                    <div class="alert alert-<?php echo $alert_type; ?> alert-dismissible fade show" role="alert">
                        <?php echo $alert_message; ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>
                <!-- Row -->
                <div class="row">
                    <div class="col-xl-12">
                        <section class="hk-sec-wrapper">
                            <form method="post">
                                <div class="form-group">
                                    <label for="class_name">Class Name</label>
                                    <input type="text" class="form-control" id="class_name" name="class_name" value="<?php echo htmlspecialchars($class['class_name']); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="course_id">Course</label>
                                    <select class="form-control" id="course_id" name="course_id" required>
                                        <?php
                                        $course_query = $conn->query("SELECT * FROM courses");
                                        while ($course = $course_query->fetch_assoc()) {
                                            $selected = ($class['course_id'] == $course['id']) ? 'selected' : '';
                                            echo "<option value='" . $course['id'] . "' $selected>" . $course['course_name'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="level_id">Level</label>
                                    <select class="form-control" id="level_id" name="level_id" required>
                                        <?php
                                        $level_query = $conn->query("SELECT * FROM levels");
                                        while ($level = $level_query->fetch_assoc()) {
                                            $selected = ($class['level_id'] == $level['id']) ? 'selected' : '';
                                            echo "<option value='" . $level['id'] . "' $selected>" . $level['name'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="department_id">Department</label>
                                    <select class="form-control" id="department_id" name="department_id" required>
                                        <?php
                                        $department_query = $conn->query("SELECT * FROM department");
                                        while ($department = $department_query->fetch_assoc()) {
                                            $selected = ($class['department_id'] == $department['id']) ? 'selected' : '';
                                            echo "<option value='" . $department['id'] . "' $selected>" . $department['name'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <button type="submit" name="update_class" class="btn btn-primary">Update Class</button>
                                <a href="manage_classes.php" class="btn btn-secondary">Back</a>
                            </form>
                        </section>
                    </div>
                </div>
                <!-- /Row -->
            </div>
            <!-- /Container -->
        </div>
        <!-- /Main Content -->
    </div>
    <!-- /HK Wrapper -->

    <script src="vendors/jquery/dist/jquery.min.js"></script>
    <script src="vendors/popper.js/dist/umd/popper.min.js"></script>
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="dist/js/feather.min.js"></script>
    <script src="dist/js/init.js"></script>
</body>
</html>
<?php
    // Close database connection
    $conn->close();
}
?>
