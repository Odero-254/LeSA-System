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

    // Check if the ID is passed and decode it
    if (isset($_GET['id'])) {
        $id = base64_decode($_GET['id']);

        // Fetch user details based on the ID
        $query = "SELECT users.id, users.username, users.email, users.phone_number, classes.class_name, users.class_id 
                  FROM users 
                  INNER JOIN classes ON users.class_id = classes.id 
                  WHERE users.id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $userDetails = $result->fetch_assoc();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $phone_number = $_POST['phone_number'];
            $class_id = $_POST['class_id'];

            // Update user details in the database
            $updateQuery = "UPDATE users SET username = ?, email = ?, phone_number = ?, class_id = ? WHERE id = ?";
            $updateStmt = $conn->prepare($updateQuery);
            $updateStmt->bind_param("sssii", $username, $email, $phone_number, $class_id, $id);

            if ($updateStmt->execute()) {
                $_SESSION['msg'] = "Class Representative details updated successfully.";
                header('location: manage_classRep.php');
                exit();
            } else {
                $error = "An error occurred. Please try again.";
            }
        }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Edit Class Representative</title>
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
                    <li class="breadcrumb-item"><a href="home.php">Users</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Class Representative</li>
                </ol>
            </nav>
            <!-- Container -->
            <div class="container">
                <!-- Title -->
                <div class="hk-pg-header">
                    <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="edit"></i></span></span>Edit Class Representative</h4>
                </div>
                <!-- Row -->
                <div class="row">
                    <div class="col-xl-12">
                        <section class="hk-sec-wrapper">
                            <div class="row">
                                <div class="col-sm">
                                    <form method="POST">
                                        <?php if (isset($error)) { ?>
                                            <div class="alert alert-danger">
                                                <?php echo $error; ?>
                                            </div>
                                        <?php } ?>
                                        <div class="form-group">
                                            <label for="username">Full Name</label>
                                            <input type="text" name="username" id="username" class="form-control" value="<?php echo $userDetails['username']; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email Address</label>
                                            <input type="email" name="email" id="email" class="form-control" value="<?php echo $userDetails['email']; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="phone_number">Phone Number</label>
                                            <input type="text" name="phone_number" id="phone_number" class="form-control" value="<?php echo $userDetails['phone_number']; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="class_id">Class</label>
                                            <select name="class_id" id="class_id" class="form-control" required>
                                                <?php
                                                // Fetch all classes
                                                $classesQuery = "SELECT id, class_name FROM classes";
                                                $classesResult = $conn->query($classesQuery);
                                                while ($classRow = $classesResult->fetch_assoc()) {
                                                    echo '<option value="'.$classRow['id'].'"'.($classRow['id'] == $userDetails['class_id'] ? ' selected' : '').'>'.$classRow['class_name'].'</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Update</button>
                                        <a href="manage_classRep.php" class="btn btn-secondary">Back</a>
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
    <script src="dist/js/init.js"></script>

    <script>
        var inactiveTimeout = <?php echo 300; ?>;
        var idleTimer;

        function resetIdleTimer() {
            clearTimeout(idleTimer);
            idleTimer = setTimeout(logoutUser, inactiveTimeout * 1000);
        }

        function logoutUser() {
            window.location.href = 'auto_logout.php';
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
    // Close the statement and connection
    $stmt->close();
    $conn->close();
    }
}
?>
