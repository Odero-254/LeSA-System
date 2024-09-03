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

    // Fetch the student ID from the URL
    $student_id = isset($_GET['id']) ? base64_decode($_GET['id']) : 0;

    // Fetch student details based on the provided ID
    $query = "SELECT students.servNo, students.name, students.phone, students.email, students.class_id, classes.class_name 
              FROM students 
              INNER JOIN classes ON students.class_id = classes.id
              WHERE students.id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $student = $result->fetch_assoc();

    if (!$student) {
        header('location:manage_students.php');
        exit();
    }

    // Update student details upon form submission
    if (isset($_POST['update'])) {
        $servNo = $_POST['servNo'];
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $class_id = $_POST['class_id'];

        $updateQuery = "UPDATE students SET servNo=?, name=?, phone=?, email=?, class_id=? WHERE id=?";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bind_param("ssssii", $servNo, $name, $phone, $email, $class_id, $student_id);
        if ($updateStmt->execute()) {
            $msg = "Student details updated successfully!";
        } else {
            $error = "Failed to update student details. Please try again.";
        }
    }

    // Fetch the logged-in user's department_id from the session
    $logged_in_user_department_id = $_SESSION['department_id'];

    // Fetch all available classes for the dropdown based on department_id
    $classQuery = "SELECT id, class_name FROM classes WHERE department_id = ?";
    $classStmt = $conn->prepare($classQuery);
    $classStmt->bind_param("i", $logged_in_user_department_id);
    $classStmt->execute();
    $classResult = $classStmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Edit Student</title>
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
                    <li class="breadcrumb-item"><a href="home.php">Students</a></li>
                    <li class="breadcrumb-item"><a href="manage_students.php">Manage</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
            </nav>
            <!-- Container -->
            <div class="container">
                <!-- Title -->
                <div class="hk-pg-header">
                    <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="edit"></i></span></span>Edit Student</h4>
                </div>
                <!-- Row -->
                <div class="row">
                    <div class="col-xl-12">
                        <section class="hk-sec-wrapper">
                            <div class="row">
                                <div class="col-sm">
                                    <?php if(isset($msg)){ ?>
                                    <div class="alert alert-success" role="alert">
                                        <?php echo $msg; ?>
                                    </div>
                                    <?php } ?>
                                    <?php if(isset($error)){ ?>
                                    <div class="alert alert-danger" role="alert">
                                        <?php echo $error; ?>
                                    </div>
                                    <?php } ?>
                                    <form method="POST">
                                        <div class="form-group">
                                            <label for="servNo">Service Number</label>
                                            <input type="text" class="form-control" id="servNo" name="servNo" value="<?php echo htmlentities($student['servNo']); ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Full Name</label>
                                            <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlentities($student['name']); ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="phone">Phone Number</label>
                                            <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlentities($student['phone']); ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email Address</label>
                                            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlentities($student['email']); ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="class_id">Class</label>
                                            <select class="form-control" id="class_id" name="class_id" required>
                                                <?php while ($class = $classResult->fetch_assoc()) { ?>
                                                <option value="<?php echo $class['id']; ?>" <?php echo $class['id'] == $student['class_id'] ? 'selected' : ''; ?>>
                                                    <?php echo htmlentities($class['class_name']); ?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <button type="submit" name="update" class="btn btn-primary">Update</button>
                                        <a href="manage_students.php" class="btn btn-secondary">Back</a>
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
    <script src="dist/js/feather.min.js"></script>
    <script src="dist/js/dropdown-bootstrap-extended.js"></script>
    <script src="dist/js/init.js"></script>
</body>
</html>
<?php
    // Close database connections
    $stmt->close();
    $classStmt->close();
    $conn->close();
}
?>
