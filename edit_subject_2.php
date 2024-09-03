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

    // Check if the form is submitted
    if (isset($_POST['update'])) {
        $subject_name = $_POST['subject_name'];
        $course_id = $_POST['course_id'];
        $level_id = $_POST['level_id'];
        $department_id = $_POST['department_id'];
        $qualifications = $_POST['qualifications'];
        
        // Update the subject details in the database
        $query = "UPDATE subjects SET course_id = ?, level_id = ?, department_id = ?, qualifications = ? WHERE subject_name = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("iiiss", $course_id, $level_id, $department_id, $qualifications, $subject_name);
        
        if ($stmt->execute()) {
            $_SESSION['msg'] = "Subject updated successfully!";
        } else {
            $_SESSION['error'] = "Error updating subject!";
        }

        // Redirect back to the manage subjects page
        header('location: manage_subject.php');
        exit();
    }

    // Fetch the subject details to be edited
    if (isset($_GET['id'])) {
        $subject_name = base64_decode($_GET['id']);
        $query = "SELECT * FROM subjects WHERE subject_name = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $subject_name);
        $stmt->execute();
        $result = $stmt->get_result();
        $subject = $result->fetch_assoc();
    } else {
        header('location: manage_subject.php');
        exit();
    }

    // Fetch course, level, and department details for dropdowns
    $courses_query = "SELECT id, course_name FROM courses";
    $levels_query = "SELECT id, name FROM levels";
    $departments_query = "SELECT id, name FROM department";

    $courses_result = $conn->query($courses_query);
    $levels_result = $conn->query($levels_query);
    $departments_result = $conn->query($departments_query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Edit Subject</title>
    <link rel="shortcut icon" href="dist/img/favicon.ico">
    <link href="vendors/datatables.net-dt/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="vendors/datatables.net-responsive-dt/css/responsive.dataTables.min.css" rel="stylesheet" type="text/css" />
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
                    <li class="breadcrumb-item"><a href="home.php">Subjects</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Subject</li>
                </ol>
            </nav>
            <!-- Container -->
            <div class="container">
                <!-- Title -->
                <div class="hk-pg-header">
                    <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="edit"></i></span></span>Edit Subject</h4>
                </div>
                <!-- Row -->
                <div class="row">
                    <div class="col-xl-12">
                        <section class="hk-sec-wrapper">
                            <div class="row">
                                <div class="col-sm">
                                    <form method="POST">
                                        <div class="form-group">
                                            <label for="subject_name">Enter Subject Name*</label>
                                            <input type="text" class="form-control" id="subject_name" name="subject_name" value="<?php echo $subject['subject_name']; ?>" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="course_id">Select Course*</label>
                                            <select class="form-control" id="course_id" name="course_id" required>
                                                <?php while ($row = $courses_result->fetch_assoc()) { ?>
                                                    <option value="<?php echo $row['id']; ?>" <?php if ($row['id'] == $subject['course_id']) echo 'selected'; ?>>
                                                        <?php echo $row['course_name']; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="level_id">Select Level*</label>
                                            <select class="form-control" id="level_id" name="level_id" required>
                                                <?php while ($row = $levels_result->fetch_assoc()) { ?>
                                                    <option value="<?php echo $row['id']; ?>" <?php if ($row['id'] == $subject['level_id']) echo 'selected'; ?>>
                                                        <?php echo $row['name']; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="department_id">Select Department*</label>
                                            <select class="form-control" id="department_id" name="department_id" required>
                                                <?php while ($row = $departments_result->fetch_assoc()) { ?>
                                                    <option value="<?php echo $row['id']; ?>" <?php if ($row['id'] == $subject['department_id']) echo 'selected'; ?>>
                                                        <?php echo $row['name']; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="qualifications">Minimum Qualifications*</label>
                                            <input type="text" class="form-control" id="qualifications" name="qualifications" value="<?php echo $subject['qualifications']; ?>" required>
                                        </div>
                                            <button class="btn btn-primary" type="submit">Save Changes</button>
                                            <a href="manage_subject.php" class="btn btn-secondary">Back to Subject List</a>
                                            <a href="add_subject.php" class="btn btn-primary">Add New Course</a>
                                        
                                    </form>
                                </div>
                            </div>
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
    <script src="dist/js/jquery.slimscroll.js"></script>
    <script src="dist/js/dropdown-bootstrap-extended.js"></script>
    <script src="dist/js/feather.min.js"></script>
    <script src="dist/js/toggle-data.js"></script>
    <script src="dist/js/init.js"></script>
</body>
</html>
<?php
    // Close database connection
    $conn->close();
}
?>
