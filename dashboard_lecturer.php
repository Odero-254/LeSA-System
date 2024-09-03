<?php
// Check if session is not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('includes/config.php');

// Redirect to logout if session user_id is not set
if (empty($_SESSION['user_id'])) {
    header('location:logout.php');
    exit; // Ensure script stops execution after redirection
}

// Update last activity time to extend session
$_SESSION['last_active_time'] = time();

// Get the logged-in user's ID
$loggedInUserId = $_SESSION['user_id'];

// Define the start and end of the current week
$startOfWeek = date("Y-m-d", strtotime("monday this week"));
$endOfWeek = date("Y-m-d", strtotime("sunday this week"));

// Query to fetch missed lessons details from the attendance table for the current week
$sqlMissedLessons = "
    SELECT a.id, l.lesson_name, c.class_name, a.lesson_date
    FROM attendance a
    JOIN lessons l ON a.lesson_id = l.id
    JOIN classes c ON a.class_id = c.id
    WHERE a.lecturer_id = ?
    AND a.status = 'missed'
    AND a.lesson_date BETWEEN ? AND ?
";
$stmtMissedLessons = $conn->prepare($sqlMissedLessons);
$stmtMissedLessons->bind_param("iss", $loggedInUserId, $startOfWeek, $endOfWeek);
$stmtMissedLessons->execute();
$resultMissedLessons = $stmtMissedLessons->get_result();

// Initialize total missed lessons count
$totalMissedLessons = $resultMissedLessons->num_rows;

// Close prepared statements
$stmtMissedLessons->close();

// Query to fetch qualified subjects for the logged-in user
$sqlQualifiedSubjects = "
    SELECT s.subject_name
    FROM lecturers l
    JOIN lecturer_subjects ls ON l.id = ls.lecturer_id
    JOIN subjects s ON ls.subject_id = s.id
    WHERE l.user_id = ?
";
$stmtQualifiedSubjects = $conn->prepare($sqlQualifiedSubjects);
$stmtQualifiedSubjects->bind_param("i", $loggedInUserId);
$stmtQualifiedSubjects->execute();
$resultQualifiedSubjects = $stmtQualifiedSubjects->get_result();

// Close prepared statements
$stmtQualifiedSubjects->close();

// Query to count unread messages from messages table for the logged-in user
$sqlUnreadMessages = "
    SELECT COUNT(*) AS total_unread_messages 
    FROM messages 
    WHERE recipient_id = ? 
    AND status = 'unread'
";
$stmtUnreadMessages = $conn->prepare($sqlUnreadMessages);
$stmtUnreadMessages->bind_param("i", $loggedInUserId);
$stmtUnreadMessages->execute();
$resultUnreadMessages = $stmtUnreadMessages->get_result();

// Check if unread messages are found
$totalUnreadMessages = 0; // Initialize total unread messages count
if ($resultUnreadMessages->num_rows > 0) {
    $unreadMessagesRow = $resultUnreadMessages->fetch_assoc();
    $totalUnreadMessages = $unreadMessagesRow['total_unread_messages']; // Set total unread messages count
}
$stmtUnreadMessages->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Dashboard</title>
    <link rel="shortcut icon" href="dist/img/favicon.ico">
    <link href="vendors/vectormap/jquery-jvectormap-2.0.3.css" rel="stylesheet" type="text/css" />
    <link href="vendors/jquery-toggles/css/toggles.css" rel="stylesheet" type="text/css">
    <link href="vendors/jquery-toggles/css/themes/toggles-light.css" rel="stylesheet" type="text/css">
    <link href="vendors/jquery-toast-plugin/dist/jquery.toast.min.css" rel="stylesheet" type="text/css">
    <link href="dist/css/style.css" rel="stylesheet" type="text/css">
</head>

<body>

    <!-- HK Wrapper -->
    <div class="hk-wrapper hk-vertical-nav">
        <?php include_once('includes/navbar.php'); ?>
        <?php include_once('includes/sidebar.php'); ?>
        <div id="hk_nav_backdrop" class="hk-nav-backdrop"></div>
        <!-- /Vertical Nav -->
        <!-- Main Content -->
        <div class="hk-pg-wrapper">
            <!-- Container -->
            <div class="container-fluid mt-xl-50 mt-sm-30 mt-15">
                <!-- Row -->
                <div class="row">
                    <div class="col-xl-12">
                        <div class="hk-row">

                            <!-- Daily Missed Lessons Section -->
                            <div class="col-lg-3 col-md-6">
                                <div class="card card-sm">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between mb-5">
                                            <div>
                                                <span class="d-block font-15 text-dark font-weight-500">Lessons that you missed this week</span>
                                            </div>
                                            <div></div>
                                        </div>
                                        <div class="text-center">
                                            <span class="d-block display-4 text-dark mb-5"><?php echo $totalMissedLessons; ?></span>
                                            <small class="d-block">Total Missed Lessons This Week</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /Daily Missed Lessons Section -->

                            <!-- Missed Lessons Details Section -->
                            <div class="col-lg-9 col-md-6">
                                <div class="card card-sm">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between mb-5">
                                            <div>
                                                <span class="d-block font-15 text-dark font-weight-500">Missed Lessons Details</span>
                                            </div>
                                            <div></div>
                                        </div>
                                        <div class="text-center">
                                            <?php if ($totalMissedLessons > 0): ?>
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Lesson Name</th>
                                                            <th>Class Name</th>
                                                            <th>Date</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php while ($row = $resultMissedLessons->fetch_assoc()): ?>
                                                            <tr>
                                                                <td><?php echo $row['id']; ?></td>
                                                                <td><?php echo $row['lesson_name']; ?></td>
                                                                <td><?php echo $row['class_name']; ?></td>
                                                                <td><?php echo $row['lesson_date']; ?></td>
                                                            </tr>
                                                        <?php endwhile; ?>
                                                    </tbody>
                                                </table>
                                            <?php else: ?>
                                                <p>No missed lessons found for this week.</p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /Missed Lessons Details Section -->

                             <!-- Unread Messages Section -->
                             <div class="col-lg-3 col-md-6">
                                <div class="card card-sm">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between mb-5">
                                            <div>
                                                <span class="d-block font-15 text-dark font-weight-500">Check your inbox for Unread Messages</span>
                                            </div>
                                            <div></div>
                                        </div>
                                        <div class="text-center">
                                            <span class="d-block display-4 text-dark mb-5"><?php echo $totalUnreadMessages; ?></span>
                                            <small class="d-block">Total Unread Messages</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /Unread messages section -->

                            <!-- Qualified Subjects Section -->
                            <div class="col-lg-12">
                                <div class="card card-sm">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between mb-5">
                                            <div>
                                                <span class="d-block font-15 text-dark font-weight-500">Qualified Subjects</span>
                                            </div>
                                            <div></div>
                                        </div>
                                        <div class="text-center">
                                            <?php if ($resultQualifiedSubjects->num_rows > 0): ?>
                                                <table class="table table-bordered">
                                                    
                                                    <tbody>
                                                        <?php while ($row = $resultQualifiedSubjects->fetch_assoc()): ?>
                                                            <tr>
                                                                <td><?php echo $row['subject_name']; ?></td>
                                                            </tr>
                                                        <?php endwhile; ?>
                                                    </tbody>
                                                </table>
                                            <?php else: ?>
                                                <p>No qualified subjects found.</p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /Qualified Subjects Section -->

                        </div>
                    </div>
                </div>
                <!-- /Row -->
            </div>
            <!-- /Container -->

        </div>
        <!-- /Main Content -->

    </div>
    <!-- /HK Wrapper -->

    <!-- JavaScript -->
    <!-- jQuery -->
    <script src="vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="vendors/popper.js/dist/umd/popper.min.js"></script>
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- Slimscroll JavaScript -->
    <script src="dist/js/jquery.slimscroll.js"></script>
    <!-- Fancy Dropdown JS -->
    <script src="dist/js/dropdown-bootstrap-extended.js"></script>
    <!-- FeatherIcons JavaScript -->
    <script src="dist/js/feather.min.js"></script>
    <!-- Toggles JavaScript -->
    <script src="vendors/jquery-toggles/toggles.min.js"></script>
    <script src="dist/js/toggle-data.js"></script>
    <!-- Counter Animation JavaScript -->
    <script src="vendors/waypoints/lib/jquery.waypoints.min.js"></script>
    <script src="vendors/jquery.counterup/jquery.counterup.min.js"></script>
    <!-- EChartJS JavaScript -->
    <script src="vendors/echarts/dist/echarts-en.min.js"></script>
    <!-- Sparkline JavaScript -->
    <script src="vendors/jquery.sparkline/dist/jquery.sparkline.min.js"></script>
    <!-- Vector Maps JavaScript -->
    <script src="vendors/vectormap/jquery-jvectormap-2.0.3.min.js"></script>
    <script src="vendors/vectormap/jquery-jvectormap-world-mill-en.js"></script>
    <script src="dist/js/vectormap-data.js"></script>
    <!-- Owl JavaScript -->
    <script src="vendors/owl.carousel/dist/owl.carousel.min.js"></script>
    <!-- Toastr JS -->
    <script src="vendors/jquery-toast-plugin/dist/jquery.toast.min.js"></script>
    <!-- Init JavaScript -->
    <script src="dist/js/init.js"></script>
    <script src="dist/js/dashboard-data.js"></script>
</body>

</html>
