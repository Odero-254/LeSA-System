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

// Get logged-in user's department ID
$loggedInUserId = $_SESSION['user_id'];
$sqlDepartment = "SELECT department_id FROM users WHERE id = ?";
$stmt = $conn->prepare($sqlDepartment);
$stmt->bind_param("i", $loggedInUserId);
$stmt->execute();
$resultDepartment = $stmt->get_result();

if ($resultDepartment->num_rows > 0) {
    $departmentRow = $resultDepartment->fetch_assoc();
    $departmentId = $departmentRow['department_id'];
} else {
    // Handle case where department ID is not found
    exit; // Exit script if department ID is not found
}

// Query to count lecturers from users table based on department and user_role
$sqlLecturers = "SELECT id, username FROM users WHERE user_role = 'Lecturer' AND department_id = ?";
$stmtLecturers = $conn->prepare($sqlLecturers);
$stmtLecturers->bind_param("i", $departmentId);
$stmtLecturers->execute();
$resultLecturers = $stmtLecturers->get_result();

// Check if lecturers are found
$totalLecturers = 0; // Initialize total lecturers count
if ($resultLecturers->num_rows > 0) {
    $totalLecturers = $resultLecturers->num_rows; // Set total lecturers count
}

// Query to count classes from classes table based on department
$sqlClasses = "SELECT COUNT(*) AS total_classes FROM classes WHERE department_id = ?";
$stmtClasses = $conn->prepare($sqlClasses);
$stmtClasses->bind_param("i", $departmentId);
$stmtClasses->execute();
$resultClasses = $stmtClasses->get_result();

// Check if classes are found
$totalClasses = 0; // Initialize total classes count
if ($resultClasses->num_rows > 0) {
    $classesRow = $resultClasses->fetch_assoc();
    $totalClasses = $classesRow['total_classes']; // Set total classes count
}

// Query to count Courses from Courses table based on department
$sqlCourses = "SELECT COUNT(*) AS total_courses FROM courses WHERE department_id = ?";
$stmtCourses = $conn->prepare($sqlCourses);
$stmtCourses->bind_param("i", $departmentId);
$stmtCourses->execute();
$resultCourses = $stmtCourses->get_result();

// Check if Courses are found
$totalCourses = 0; // Initialize total Courses count
if ($resultCourses->num_rows > 0) {
    $coursesRow = $resultCourses->fetch_assoc();
    $totalCourses = $coursesRow['total_courses']; // Set total Courses count
}

// Query to count Students from Students table based on department
$sqlStudents = "SELECT COUNT(*) AS total_students FROM students WHERE department_id = ?";
$stmtStudents = $conn->prepare($sqlStudents);
$stmtStudents->bind_param("i", $departmentId);
$stmtStudents->execute();
$resultStudents = $stmtStudents->get_result();

// Check if Courses are found
$totalStudents = 0; // Initialize total Students count
if ($resultStudents->num_rows > 0) {
    $studentsRow = $resultStudents->fetch_assoc();
    $totalStudents = $studentsRow['total_students']; // Set total Students count
}

// Query to count Class Representatives from users table based on class and user_role
$sqlCRep = "SELECT id, username FROM users WHERE user_role = 'Class Representative' AND department_id = ?";
$stmtCRep = $conn->prepare($sqlCRep);
$stmtCRep->bind_param("i", $departmentId);
$stmtCRep->execute();
$resultCRep = $stmtCRep->get_result();

// Check if Class representatives are found
$totalCRep = 0; // Initialize total Class representative count
if ($resultCRep->num_rows > 0) {
    $totalCRep = $resultCRep->num_rows; // Set total Class representative count
}

// Query to count Missed Lessons from attendance table based on lesson id and status
$sqlMissedLesson = "SELECT id, lesson_id FROM attendance WHERE status = 'missed' AND department_id = ?";
$stmtMissedLesson = $conn->prepare($sqlMissedLesson);
$stmtMissedLesson->bind_param("i", $departmentId);
$stmtMissedLesson->execute();
$resultMissedLesson = $stmtMissedLesson->get_result();

// Check if Missed Lessons are found
$totalMissedLesson = 0; // Initialize total Missed Lessons count
if ($resultMissedLesson->num_rows > 0) {
    $totalMissedLesson = $resultMissedLesson->num_rows; // Set total Missed Lessons count
}

// Query to count Daily Missed Lessons
$startOfDay = date('Y-m-d 00:00:00');
$endOfDay = date('Y-m-d 23:59:59');
$sqlDailyMissedLessons = "SELECT COUNT(*) AS daily_missed_lessons FROM attendance WHERE status = 'missed' AND department_id = ? AND timestamp BETWEEN ? AND ?";
$stmtDailyMissedLessons = $conn->prepare($sqlDailyMissedLessons);
$stmtDailyMissedLessons->bind_param("iss", $departmentId, $startOfDay, $endOfDay);
$stmtDailyMissedLessons->execute();
$resultDailyMissedLessons = $stmtDailyMissedLessons->get_result();

// Check if Daily Missed Lessons are found
$dailyMissedLessons = 0; // Initialize total Daily Missed Lessons count
if ($resultDailyMissedLessons->num_rows > 0) {
    $dailyMissedLessonsRow = $resultDailyMissedLessons->fetch_assoc();
    $dailyMissedLessons = $dailyMissedLessonsRow['daily_missed_lessons']; // Set total Daily Missed Lessons count
}

// Query to count Absent Students from student_absence table based on department_id
$sqlAbsentStudents = "SELECT COUNT(*) AS total_absent_students FROM student_absence WHERE department_id = ?";
$stmtAbsentStudents = $conn->prepare($sqlAbsentStudents);
$stmtAbsentStudents->bind_param("i", $departmentId);
$stmtAbsentStudents->execute();
$resultAbsentStudents = $stmtAbsentStudents->get_result();

// Check if absent students are found
$totalAbsentStudents = 0; // Initialize total Absent Students count
if ($resultAbsentStudents->num_rows > 0) {
    $absentStudentsRow = $resultAbsentStudents->fetch_assoc();
    $totalAbsentStudents = $absentStudentsRow['total_absent_students']; // Set total Absent Students count
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
$stmtLecturers->close();
$stmtClasses->close();
$stmtCourses->close();
$stmtStudents->close();
$stmtCRep->close();
$stmtMissedLesson->close();
$stmtDailyMissedLessons->close();
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

    <!--- <style>
        .card.card-sm .card-body {
            background-color: #EDF9FE;
        }
    </style>
    --->
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

                            <!-- Lecturers Section -->
                            <div class="col-lg-3 col-md-6">
                                <div class="card card-sm">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between mb-5">
                                            <div>
                                                <span class="d-block font-15 text-dark font-weight-500">Lecturers in your Department</span>
                                            </div>
                                            <div>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <span class="d-block display-4 text-dark mb-5"><?php echo $totalLecturers; ?></span>
                                            <small class="d-block">Total Lecturers</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Classes Section -->
                            <div class="col-lg-3 col-md-6">
                                <div class="card card-sm">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between mb-5">
                                            <div>
                                                <span class="d-block font-15 text-dark font-weight-500">Classes in your Department</span>
                                            </div>
                                            <div>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <span class="d-block display-4 text-dark mb-5"><?php echo $totalClasses; ?></span>
                                            <small class="d-block">Total Classes</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Courses Section -->
                            <div class="col-lg-3 col-md-6">
                                <div class="card card-sm">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between mb-5">
                                            <div>
                                                <span class="d-block font-15 text-dark font-weight-500">Courses in your Department</span>
                                            </div>
                                            <div>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <span class="d-block display-4 text-dark mb-5"><?php echo $totalCourses; ?></span>
                                            <small class="d-block">Total Courses</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Students Section -->
                            <div class="col-lg-3 col-md-6">
                                <div class="card card-sm">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between mb-5">
                                            <div>
                                                <span class="d-block font-15 text-dark font-weight-500">Students in your Department</span>
                                            </div>
                                            <div>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <span class="d-block display-4 text-dark mb-5"><?php echo $totalStudents; ?></span>
                                            <small class="d-block">Total Students</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Class Representatives Section -->
                            <div class="col-lg-3 col-md-6">
                                <div class="card card-sm">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between mb-5">
                                            <div>
                                                <span class="d-block font-15 text-dark font-weight-500">Class Representatives in your Department</span>
                                            </div>
                                            <div>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <span class="d-block display-4 text-dark mb-5"><?php echo $totalCRep; ?></span>
                                            <small class="d-block">Total Class Representatives</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Missed Lessons Section -->
                            <div class="col-lg-3 col-md-6">
                                <div class="card card-sm">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between mb-5">
                                            <div>
                                                <span class="d-block font-15 text-dark font-weight-500">Missed Lessons in your Department</span>
                                            </div>
                                            <div>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <span class="d-block display-4 text-dark mb-5"><?php echo $totalMissedLesson; ?></span>
                                            <small class="d-block">Total Missed Lessons</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- daily Absent Students Section -->
                            <div class="col-lg-3 col-md-6">
                                <div class="card card-sm">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between mb-5">
                                            <div>
                                                <span class="d-block font-15 text-dark font-weight-500">Absent Students in your Department Today</span>
                                            </div>
                                            <div>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <span class="d-block display-4 text-dark mb-5"><?php echo $totalAbsentStudents; ?></span>
                                            <small class="d-block">Daily Absent Students</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Daily missed lesson section-->
                            <div class="col-lg-3 col-md-6">
                                <div class="card card-sm">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between mb-5">
                                            <div>
                                                <span class="d-block font-15 text-dark font-weight-500">Missed lessons in your Department Today</span>
                                            </div>
                                            <div>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                        <span class="d-block display-4 text-dark mb-5"><?php echo $dailyMissedLessons; ?></span>
                                            <small class="d-block">Daily Missed Lessons</small>
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
                                                <span class="d-block font-15 text-dark font-weight-500">Your Unread Messages</span>
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
