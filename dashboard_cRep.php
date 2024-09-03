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

// Get logged-in user's class ID
$loggedInUserId = $_SESSION['user_id'];
$sqlClassId = "SELECT class_id FROM users WHERE id = ?";
$stmt = $conn->prepare($sqlClassId);
$stmt->bind_param("i", $loggedInUserId);
$stmt->execute();
$resultClassId = $stmt->get_result();

if ($resultClassId->num_rows > 0) {
    $classRow = $resultClassId->fetch_assoc();
    $classId = $classRow['class_id'];
} else {
    // Handle case where class ID is not found
    exit; // Exit script if class ID is not found
}

// Query to count students from students table based on class_id
$sqlStudents = "SELECT COUNT(*) AS total_students FROM students WHERE class_id = ?";
$stmtStudents = $conn->prepare($sqlStudents);
$stmtStudents->bind_param("i", $classId);
$stmtStudents->execute();
$resultStudents = $stmtStudents->get_result();

// Check if students are found
$totalStudents = 0; // Initialize total students count
if ($resultStudents->num_rows > 0) {
    $studentsRow = $resultStudents->fetch_assoc();
    $totalStudents = $studentsRow['total_students']; // Set total students count
}

// Query to count lecturers from allocations table based on class_id
$sqlLecturers = "SELECT COUNT(DISTINCT lecturer_id) AS total_lecturers FROM allocations WHERE class_id = ?";
$stmtLecturers = $conn->prepare($sqlLecturers);
$stmtLecturers->bind_param("i", $classId);
$stmtLecturers->execute();
$resultLecturers = $stmtLecturers->get_result();

// Check if lecturers are found
$totalLecturers = 0; // Initialize total lecturers count
if ($resultLecturers->num_rows > 0) {
    $lecturersRow = $resultLecturers->fetch_assoc();
    $totalLecturers = $lecturersRow['total_lecturers']; // Set total lecturers count
}

// Query to count subjects from subjects table based on class_id
$sqlSubjects = "SELECT COUNT(*) AS total_subjects FROM subjects WHERE class_id = ?";
$stmtSubjects = $conn->prepare($sqlSubjects);
$stmtSubjects->bind_param("i", $classId);
$stmtSubjects->execute();
$resultSubjects = $stmtSubjects->get_result();

// Check if subjects are found
$totalSubjects = 0; // Initialize total subjects count
if ($resultSubjects->num_rows > 0) {
    $subjectsRow = $resultSubjects->fetch_assoc();
    $totalSubjects = $subjectsRow['total_subjects']; // Set total subjects count
}

// Calculate start and end of the week for the current week (Monday to Sunday)
$startOfWeek = date('Y-m-d 00:00:00', strtotime('monday this week'));
$endOfWeek = date('Y-m-d 23:59:59', strtotime('sunday this week'));

// Query to count missed lessons from attendance table for the current week
$sqlMissedLessons = "
    SELECT COUNT(*) AS total_missed_lessons 
    FROM attendance 
    WHERE class_id = ? 
    AND lesson_date BETWEEN ? AND ?
";
$stmtMissedLessons = $conn->prepare($sqlMissedLessons);
$stmtMissedLessons->bind_param("iss", $classId, $startOfWeek, $endOfWeek);
$stmtMissedLessons->execute();
$resultMissedLessons = $stmtMissedLessons->get_result();

// Check if missed lessons are found
$totalMissedLessons = 0; // Initialize total missed lessons count
if ($resultMissedLessons->num_rows > 0) {
    $missedLessonsRow = $resultMissedLessons->fetch_assoc();
    $totalMissedLessons = $missedLessonsRow['total_missed_lessons']; // Set total missed lessons count
}

// Query to count absent students from student_absence table for the current week
$sqlAbsentStudents = "
    SELECT COUNT(DISTINCT student_id) AS total_absent_students 
    FROM student_absence 
    WHERE class_id = ? 
    AND day_of_the_week BETWEEN ? AND ?
";
$stmtAbsentStudents = $conn->prepare($sqlAbsentStudents);
$stmtAbsentStudents->bind_param("iss", $classId, $startOfWeek, $endOfWeek);
$stmtAbsentStudents->execute();
$resultAbsentStudents = $stmtAbsentStudents->get_result();

// Check if absent students are found
$totalAbsentStudents = 0; // Initialize total absent students count
if ($resultAbsentStudents->num_rows > 0) {
    $absentStudentsRow = $resultAbsentStudents->fetch_assoc();
    $totalAbsentStudents = $absentStudentsRow['total_absent_students']; // Set total absent students count
}

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

// Close prepared statements
$stmt->close();
$stmtStudents->close();
$stmtLecturers->close();
$stmtSubjects->close();
$stmtMissedLessons->close();
$stmtAbsentStudents->close();
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

                            <!-- Students Section -->
                            <div class="col-lg-3 col-md-6">
                                <div class="card card-sm">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between mb-5">
                                            <div>
                                                <span class="d-block font-15 text-dark font-weight-500">Total Registered Students in your Class</span>
                                            </div>
                                            <div></div>
                                        </div>
                                        <div class="text-center">
                                            <span class="d-block display-4 text-dark mb-5"><?php echo $totalStudents; ?></span>
                                            <small class="d-block">Total Students</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Lecturers Section -->
                            <div class="col-lg-3 col-md-6">
                                <div class="card card-sm">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between mb-5">
                                            <div>
                                                <span class="d-block font-15 text-dark font-weight-500">Total Allocated Lecturers in your Class</span>
                                            </div>
                                            <div></div>
                                        </div>
                                        <div class="text-center">
                                            <span class="d-block display-4 text-dark mb-5"><?php echo $totalLecturers; ?></span>
                                            <small class="d-block">Total Lecturers</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Subjects Section -->
                            <div class="col-lg-3 col-md-6">
                                <div class="card card-sm">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between mb-5">
                                            <div>
                                                <span class="d-block font-15 text-dark font-weight-500">Total Subjects/Units Taught in your Class</span>
                                            </div>
                                            <div></div>
                                        </div>
                                        <div class="text-center">
                                            <span class="d-block display-4 text-dark mb-5"><?php echo $totalSubjects; ?></span>
                                            <small class="d-block">Total Subjects/Units</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Weekly Missed Lessons Section -->
                            <div class="col-lg-3 col-md-6">
                                <div class="card card-sm">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between mb-5">
                                            <div>
                                                <span class="d-block font-15 text-dark font-weight-500">Weekly Missed Lessons in your Class</span>
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

                            <!-- Weekly Absent Students Section -->
                            <div class="col-lg-3 col-md-6">
                                <div class="card card-sm">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between mb-5">
                                            <div>
                                                <span class="d-block font-15 text-dark font-weight-500">Weekly Absent Students in your Class</span>
                                            </div>
                                            <div></div>
                                        </div>
                                        <div class="text-center">
                                            <span class="d-block display-4 text-dark mb-5"><?php echo $totalAbsentStudents; ?></span>
                                            <small class="d-block">Total Absent Students This Week</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

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
