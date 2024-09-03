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

    // Handle class deletion
    if (isset($_GET['del'])) {
        $class_name = base64_decode($_GET['del']);
        $stmt = $conn->prepare("DELETE FROM classes WHERE class_name = ?");
        $stmt->bind_param("s", $class_name);
        
        if ($stmt->execute()) {
            $alert_message = "Class deleted successfully!";
            $alert_type = "success";
        } else {
            $alert_message = "Failed to delete class. Please try again.";
            $alert_type = "danger";
        }
        
        $stmt->close();
    }

    // Fetch classes with course, level, and department details
    $query = "SELECT classes.class_name, courses.course_name AS course_offered, levels.name AS course_level, department.name AS department_name
              FROM classes
              INNER JOIN courses ON classes.course_id = courses.id
              INNER JOIN levels ON classes.level_id = levels.id
              INNER JOIN department ON classes.department_id = department.id";

    $result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Manage Classes</title>
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
                    <li class="breadcrumb-item"><a href="home.php">Classes</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Manage</li>
                </ol>
            </nav>
            <!-- Container -->
            <div class="container">
                <!-- Title -->
                <div class="hk-pg-header">
                    <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="database"></i></span></span>Manage Classes</h4>
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
                            <div class="row">
                                <div class="col-sm">
                                    <div class="table-wrap">
                                        <?php if ($result->num_rows > 0): ?>
                                        <table id="datable_1" class="table table-hover w-100 display pb-30">
                                            <thead>
                                                <tr>
                                                    <th>SNo</th>
                                                    <th>Class Name</th>
                                                    <th>Course Offered</th>
                                                    <th>Course Level</th>
                                                    <th>Department</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $cnt = 1;
                                                while ($row = $result->fetch_assoc()) {    
                                                ?>                                                
                                                <tr>
                                                    <td><?php echo $cnt; ?></td>
                                                    <td><?php echo $row['class_name']; ?></td>
                                                    <td><?php echo $row['course_offered']; ?></td>
                                                    <td><?php echo $row['course_level']; ?></td>
                                                    <td><?php echo $row['department_name']; ?></td>
                                                    <td>
                                                        <a href="edit_class_2.php?id=<?php echo base64_encode($row['class_name']); ?>" data-toggle="tooltip" data-original-title="Edit"> <i class="icon-pencil"></i> </a>
                                                        <a href="manage_class.php?del=<?php echo base64_encode($row['class_name']); ?>" data-toggle="tooltip" data-original-title="Delete" onclick="return confirm('Do you really want to delete?');"> <i class="icon-trash txt-danger"></i> </a>
                                                    </td>
                                                </tr>
                                                <?php 
                                                $cnt++;
                                                } ?>
                                            </tbody>
                                        </table>
                                        <?php else: ?>
                                            <p class="text-danger">No classes found.</p>
                                        <?php endif; ?>
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

    <script src="vendors/jquery/dist/jquery.min.js"></script>
    <script src="vendors/popper.js/dist/umd/popper.min.js"></script>
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="dist/js/jquery.slimscroll.js"></script>
    <script src="vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="vendors/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="vendors/datatables.net-dt/js/dataTables.dataTables.min.js"></script>
    <script src="vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="vendors/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
    <script src="vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="vendors/jszip/dist/jszip.min.js"></script>
    <script src="vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="vendors/pdfmake/build/vfs_fonts.js"></script>
    <script src="vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="dist/js/dataTables-data.js"></script>
    <script src="dist/js/feather.min.js"></script>
    <script src="dist/js/dropdown-bootstrap-extended.js"></script>
    <script src="vendors/jquery-toggles/toggles.min.js"></script>
    <script src="dist/js/toggle-data.js"></script>
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
    // Close database connection
    $conn->close();
}
?>
