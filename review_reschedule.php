<?php
// Start the session
session_start();
require 'includes/config.php';

// Check user role
if ($_SESSION['user_role'] !== 'Class Representative') {
    echo "Access denied!";
    exit;
}

// Fetch pending reschedule requests
$sql = "SELECT rl.*, u.username AS lecturer_name, s.subject_name AS subject_name FROM rescheduled_lessons rl
        JOIN allocations a ON rl.allocation_id = a.id
        JOIN users u ON a.lecturer_id = u.id
        JOIN subjects s ON a.subject_id = s.id
        WHERE rl.status = 'pending' AND a.class_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION['class_id']);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Reschedule Requests</title>
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
                    <li class="breadcrumb-item"><a href="dashboard_cRep.php">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Reschedule Requests</li>
                </ol>
            </nav>
            <!-- Container -->
            <div class="container">
                <!-- Title -->
                <div class="hk-pg-header">
                    <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="clock"></i></span></span>Reschedule Requests</h4>
                </div>
                <!-- Row -->
                <div class="row">
                    <div class="col-xl-12">
                        <section class="hk-sec-wrapper">
                            <div class="table-wrap">
                                <table id="datable_1" class="table table-hover w-100 display pb-30">
                                    <thead>
                                        <tr>
                                            <th>Lecturer</th>
                                            <th>Subject</th>
                                            <th>New Start Time</th>
                                            <th>New End Time</th>
                                            <th>Day</th>
                                            <th>Date</th>
                                            <th>Reason</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($row = $result->fetch_assoc()) { ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($row['lecturer_name']); ?></td>
                                                <td><?php echo htmlspecialchars($row['subject_name']); ?></td>
                                                <td><?php echo htmlspecialchars($row['new_start_time']); ?></td>
                                                <td><?php echo htmlspecialchars($row['new_end_time']); ?></td>
                                                <td><?php echo htmlspecialchars($row['new_day_of_week']); ?></td>
                                                <td><?php echo htmlspecialchars($row['new_date']); ?></td>
                                                <td><?php echo htmlspecialchars($row['reason']); ?></td>
                                                <td>
                                                    <a href="process_reschedule.php?id=<?php echo $row['id']; ?>&action=approve" class="btn btn-success btn-sm">Approve</a>
                                                    <a href="process_reschedule.php?id=<?php echo $row['id']; ?>&action=reject" class="btn btn-danger btn-sm">Reject</a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
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
// Close the statement and connection
$stmt->close();
$conn->close();
?>
