<?php
// Check if session is not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once 'includes/config.php';

// Initialize alert message variables
$alertMessage = '';
$alertType = '';

// Check if user is logged in and get department_id
if (!isset($_SESSION['user_id'])) {
    die("Please log in first.");
}

$user_id = $_SESSION['user_id'];
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the department_id of the logged-in user
$result = $conn->query("SELECT department_id FROM users WHERE id = $user_id");
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $department_id = $row['department_id'];
} else {
    die("Failed to retrieve department ID.");
}

// Fetch courses for the department_id
$courses_result = $conn->query("SELECT id, course_name FROM courses WHERE department_id = $department_id");
if ($courses_result === false) {
    die('Query failed: ' . htmlspecialchars($conn->error));
}

$courses = [];
while ($row = $courses_result->fetch_assoc()) {
    $courses[] = $row;
}

// Fetch classes for the department_id
$classes_result = $conn->query("SELECT id, class_name FROM classes WHERE department_id = $department_id");
if ($classes_result === false) {
    die('Query failed: ' . htmlspecialchars($conn->error));
}

$classes = [];
while ($row = $classes_result->fetch_assoc()) {
    $classes[] = $row;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_student'])) {
    $servNo = $_POST['service_number'];
    $name = $_POST['name'];
    $phone = $_POST['phone_number'];
    $email = $_POST['email'];
    $course_id = $_POST['course_id'];
    $class_id = $_POST['class_id'];

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO students (servNo, name, phone, email, department_id, course_id, class_id) VALUES (?, ?, ?, ?, ?, ?, ?)");

    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }

    $stmt->bind_param("ssssiii", $servNo, $name, $phone, $email, $department_id, $course_id, $class_id);

    // Execute the statement
    if ($stmt->execute()) {
        $alertMessage = 'Student added successfully.';
        $alertType = 'success';
    } else {
        $alertMessage = 'Error: ' . htmlspecialchars($stmt->error);
        $alertType = 'danger';
    }

    $stmt->close();
}

// Handle file upload
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['upload_students'])) {
    if (isset($_FILES['students_file']) && $_FILES['students_file']['error'] == 0) {
        $fileType = mime_content_type($_FILES['students_file']['tmp_name']);
        if ($fileType == 'text/plain' || $fileType == 'text/csv') {
            $file = $_FILES['students_file']['tmp_name'];
            $handle = fopen($file, 'r');
            
            if ($handle) {
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    $servNo = $data[0];
                    $name = $data[1];
                    $phone = $data[2];
                    $email = $data[3];
                    $course_id = $data[4];
                    $class_id = $data[5];

                    // Prepare and bind
                    $stmt = $conn->prepare("INSERT INTO students (servNo, name, phone, email, department_id, course_id, class_id) VALUES (?, ?, ?, ?, ?, ?, ?)");

                    if ($stmt === false) {
                        die('Prepare failed: ' . htmlspecialchars($conn->error));
                    }

                    $stmt->bind_param("ssssiii", $servNo, $name, $phone, $email, $department_id, $course_id, $class_id);

                    // Execute the statement
                    if (!$stmt->execute()) {
                        $alertMessage = 'Error: ' . htmlspecialchars($stmt->error);
                        $alertType = 'danger';
                        break;
                    }
                    $stmt->close();
                }

                if ($alertMessage == '') {
                    $alertMessage = 'Students uploaded and added successfully.';
                    $alertType = 'success';
                }
                
                fclose($handle);
            }
        } else {
            $alertMessage = 'Invalid file format. Please upload a CSV file.';
            $alertType = 'danger';
        }
    } else {
        $alertMessage = 'Error uploading file.';
        $alertType = 'danger';
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
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
                <li class="breadcrumb-item active" aria-current="page">Add Student</li>
            </ol>
        </nav>
        <!-- /Breadcrumb -->

        <!-- Container -->
        <div class="container">
            <!-- Title -->
            <div class="hk-pg-header">
                <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="external-link"></i></span></span>Add Students</h4>
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
                                <div class="container">
                                    <!-- Add Student Form -->
                                    <form method="POST" action="">
                                        <h4>Enter Student Details</h4><br>

                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label for="validationCustom03">Service Number*</label>
                                                <input type="number" class="form-control" id="validationCustom03" placeholder="Enter the service number" name="service_number" required>
                                                <div class="invalid-feedback">Please provide a valid service number.</div>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label for="validationCustom03">Full Name*</label>
                                                <input type="text" class="form-control" id="validationCustom03" placeholder="Enter the full name" name="name" required>
                                                <div class="invalid-feedback">Please provide a valid name.</div>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label for="validationCustom03">Phone Number*</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="inputGroupPrepend">+254</span>
                                                    </div>
                                                    <input type="text" class="form-control" id="validationCustom03" placeholder="Enter phone number excluding the first 0" name="phone_number" required>
                                                    <div class="invalid-feedback">Please provide a valid phone number.</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label for="validationCustom03">Email Address*</label>
                                                <input type="email" class="form-control" id="validationCustom03" placeholder="Enter email address" name="email" required>
                                                <div class="invalid-feedback">Please provide a valid email address.</div>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label for="validationCustom03">Select Course*</label>
                                                <select class="form-control custom-select" name="course_id" required>
                                                    <option value="">Select Course</option>
                                                    <?php foreach ($courses as $course): ?>
                                                        <option value="<?php echo $course['id']; ?>"><?php echo $course['course_name']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <div class="invalid-feedback">Please select a course.</div>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label for="validationCustom03">Select Class*</label>
                                                <select class="form-control custom-select" name="class_id" required>
                                                    <option value="">Select Class</option>
                                                    <?php foreach ($classes as $class): ?>
                                                        <option value="<?php echo $class['id']; ?>"><?php echo $class['class_name']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <div class="invalid-feedback">Please select a class.</div>
                                            </div>
                                        </div>
                                        
                                        <button class="btn btn-primary" type="submit" name="add_student">Add Student</button>
                                        <a href="dashboard_hod.php" class="btn btn-secondary">Back</a>
                                    </form>
                                    <!-- /Add Student Form -->
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            <!-- /Row -->

            <!-- Row -->
            <div class="row">
                <div class="col-xl-12">
                    <section class="hk-sec-wrapper">
                        <div class="row">
                            <div class="col-sm">
                                <div class="container">
                                    <!-- Upload Students Form -->
                                    <form method="POST" action="" enctype="multipart/form-data">
                                        <h4>Upload CSV File</h4><br>

                                        <div class="form-group">
                                            <div class="col-md-6 mb-10">
                                                <label for="students_file">Upload CSV file with appropriate columns</label>
                                                <input type="file" class="form-control-file" name="students_file" accept=".csv" required>
                                                <div class="invalid-feedback">Please provide a valid CSV file.</div>
                                            </div>
                                        </div>
                                        
                                        <button class="btn btn-primary" type="submit" name="upload_students">Upload file</button>
                                    </form>
                                    <!-- /Upload Students Form -->
                                </div>
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

<!-- Scripts -->
<script src="vendors/jquery/dist/jquery.min.js"></script>
<script src="vendors/popper.js/dist/umd/popper.min.js"></script>
<script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="dist/js/bootstrap-toast.min.js"></script>
<script src="vendors/jasny-bootstrap/dist/js/jasny-bootstrap.min.js"></script>
<script src="dist/js/feather.min.js"></script>
<script src="dist/js/init.js"></script>

</body>
</html>
