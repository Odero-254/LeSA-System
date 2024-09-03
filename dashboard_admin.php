<?php
// Check if session is not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
//error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['user_id']) == 0){
  header('location:logout.php');
  } else{ 
    // Update last activity time to extend session
    $_SESSION['last_active_time'] = time();
  
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

<?php include_once('includes/navbar.php');
include_once('includes/sidebar.php');
?>
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

<?php
$query=mysqli_query($conn,"select id from department");
$listedDep=mysqli_num_rows($query);
?>

<div class="col-lg-3 col-md-6">
    <div class="card card-sm">
        <div class="card-body">
        <div class="d-flex justify-content-between mb-5">
<div>
<span class="d-block font-15 text-dark font-weight-500">Departments</span>
</div>
    <div>
        </div>
            </div>
                <div class="text-center">
                    <span class="d-block display-4 text-dark mb-5"><?php echo $listedDep;?></span>
                <small class="d-block">Total Number of Departments</small>
            </div>
        </div>
    </div>
</div>
							

<?php
$ret=mysqli_query($conn,"SELECT * FROM lecturers"); 
$listedLec=mysqli_num_rows($ret);
?>
    <div class="col-lg-3 col-md-6">
        <div class="card card-sm">
            <div class="card-body">
        <div class="d-flex justify-content-between mb-5">
    <div>
<span class="d-block font-15 text-dark font-weight-500">Lecturers</span>
        </div>
            <div>
                </div>
                    </div>
                        <div class="text-center">
                            <span class="d-block display-4 text-dark mb-5"><?php echo $listedLec;?></span>
                <small class="d-block">Total Number of Lecturers</small>
            </div>
        </div>
    </div>
</div>
							
<?php
$sql = mysqli_query($conn, "SELECT * FROM users WHERE user_role = 'HOD'");
$hodUsersCount = mysqli_num_rows($sql);

// Fetching all HOD users
$hodUsers = [];
while ($row = mysqli_fetch_assoc($sql)) {
    $hodUsers[] = $row;
}

// Now $hodUsers contains all the users whose role is HOD
?>
<div class="col-lg-3 col-md-6">
<div class="card card-sm">
<div class="card-body">
<div class="d-flex justify-content-between mb-5">
<div>
<span class="d-block font-15 text-dark font-weight-500">H.O.Ds</span>
</div>
<div>
</div>
</div>
<div class="text-center">
<span class="d-block display-4 text-dark mb-5"><?php echo $hodUsersCount;?></span>
<small class="d-block">Total Head of Departments</small>
</div>
</div>
</div>
</div>

<?php
$query = mysqli_query($conn, "SELECT * FROM classes");
$classesCount = mysqli_num_rows($query);

// Fetching all classes
$classes = [];
while ($row = mysqli_fetch_assoc($query)) {
    $classes[] = $row;
}

// Now $classes contains all the records from the classes table

?>
<div class="col-lg-3 col-md-6">
<div class="card card-sm">
<div class="card-body">
<div class="d-flex justify-content-between mb-5">
<div>
<span class="d-block font-15 text-dark font-weight-500">Classes</span>
</div>
<div>
</div>
</div>
<div class="text-center">
<span class="d-block display-4 text-dark mb-5"><?php echo $classesCount;?></span>
<small class="d-block">Total Classes</small>
</div>
</div>
</div>
</div>	


<?php
$query = mysqli_query($conn, "SELECT * FROM students");
$studentsCount = mysqli_num_rows($query);

// Fetching all students
$students = [];
while ($row = mysqli_fetch_assoc($query)) {
    $students[] = $row;
}

// Now $students contains all the records from the students table

?>
<div class="col-lg-3 col-md-6">
<div class="card card-sm">
<div class="card-body">
<div class="d-flex justify-content-between mb-5">
<div>
<span class="d-block font-15 text-dark font-weight-500">Students</span>
</div>
<div>
</div>
</div>
<div class="text-center">
<span class="d-block display-4 text-dark mb-5"><?php echo $studentsCount;?></span>
<small class="d-block">Total Number of Students</small>
</div>
</div>
</div>
</div>



<?php
$query=mysqli_query($conn,"select id from courses");
$listedCour=mysqli_num_rows($query);
?>

<div class="col-lg-3 col-md-6">
    <div class="card card-sm">
        <div class="card-body">
        <div class="d-flex justify-content-between mb-5">
<div>
<span class="d-block font-15 text-dark font-weight-500">Courses</span>
</div>
    <div>
        </div>
            </div>
                <div class="text-center">
                    <span class="d-block display-4 text-dark mb-5"><?php echo $listedCour;?></span>
                <small class="d-block">Total Number of Courses Offered</small>
            </div>
        </div>
    </div>
</div>

<?php
$query = mysqli_query($conn, "SELECT * FROM attendance WHERE status = 'missed'");
$missedLessonsCount = mysqli_num_rows($query);

// Fetching all missed lessons
$missedLessons = [];
while ($row = mysqli_fetch_assoc($query)) {
    $missedLessons[] = $row;
}

// Now $missedLessons contains all the records from the attendance table where status is 'missed'

?>
<div class="col-lg-3 col-md-6">
<div class="card card-sm">
<div class="card-body">
<div class="d-flex justify-content-between mb-5">
<div>
<span class="d-block font-15 text-dark font-weight-500">Missed Lessons</span>
</div>
<div>
</div>
</div>
<div class="text-center">
<span class="d-block display-4 text-dark mb-5"><?php echo $missedLessonsCount;?></span>
<small class="d-block">Today missed lessons</small>
</div>
</div>
</div>
</div>

<?php
$query = mysqli_query($conn, "SELECT * FROM attendance WHERE status = 'makeUp'");
$rescheduledLessonsCount = mysqli_num_rows($query);

// Fetching all missed lessons
$rescheduledLessons = [];
while ($row = mysqli_fetch_assoc($query)) {
    $rescheduledLessons[] = $row;
}

// Now $missedLessons contains all the records from the attendance table where status is 'missed'

?>
<div class="col-lg-3 col-md-6">
<div class="card card-sm">
<div class="card-body">
<div class="d-flex justify-content-between mb-5">
<div>
<span class="d-block font-15 text-dark font-weight-500">Rescheduled Classes</span>
</div>
<div>
</div>
</div>
<div class="text-center">
<span class="d-block display-4 text-dark mb-5"><?php echo $rescheduledLessonsCount;?></span>
<small class="d-block">Today recheduled classes</small>
</div>
</div>
</div>
</div>



<?php
$query = mysqli_query($conn, "SELECT * FROM attendance WHERE status = 'missed'");
$missedLessonsCount = mysqli_num_rows($query);

// Fetching all missed lessons
$missedLessons = [];
while ($row = mysqli_fetch_assoc($query)) {
    $missedLessons[] = $row;
}

// Now $missedLessons contains all the records from the attendance table where status is 'missed'

?>
<div class="col-lg-3 col-md-6">
<div class="card card-sm">
<div class="card-body">
<div class="d-flex justify-content-between mb-5">
<div>
<span class="d-block font-15 text-dark font-weight-500">Total Missed Classes</span>
</div>
<div>
</div>
</div>
<div class="text-center">
<span class="d-block display-4 text-dark mb-5"><?php echo $missedLessonsCount;?></span>
<small class="d-block">Total missed classes till date</small>
</div>
</div>
</div>
</div>


<?php
$query = mysqli_query($conn, "SELECT * FROM attendance WHERE status = 'makeUp'");
$rescheduledLessonsCount = mysqli_num_rows($query);

// Fetching all missed lessons
$rescheduledLessons = [];
while ($row = mysqli_fetch_assoc($query)) {
    $rescheduledLessons[] = $row;
}
?>
<div class="col-lg-3 col-md-6">
<div class="card card-sm">
<div class="card-body">
<div class="d-flex justify-content-between mb-5">
<div>
<span class="d-block font-15 text-dark font-weight-500">Total Rescheduled Classes</span>
</div>
<div>
</div>
</div>
<div class="text-center">
<span class="d-block display-4 text-dark mb-5"><?php echo $rescheduledLessonsCount;?></span>
<small class="d-block">Total rescheduled classes till date</small>
</div>
</div>
</div>
</div>


<?php
$sql = mysqli_query($conn, "SELECT * FROM users WHERE user_role = 'Class Representative'");
$hodUsersCount = mysqli_num_rows($sql);

// Fetching all HOD users
$hodUsers = [];
while ($row = mysqli_fetch_assoc($sql)) {
    $hodUsers[] = $row;
}

// Now $hodUsers contains all the users whose role is HOD
?>
<div class="col-lg-3 col-md-6">
<div class="card card-sm">
<div class="card-body">
<div class="d-flex justify-content-between mb-5">
<div>
<span class="d-block font-15 text-dark font-weight-500">Class Representatives</span>
</div>
<div>
</div>
</div>
<div class="text-center">
<span class="d-block display-4 text-dark mb-5"><?php echo $hodUsersCount;?></span>
<small class="d-block">Total Number Of Class Reps</small>
</div>
</div>
</div>
</div>

<?php
$loggedInUserId = $_SESSION['user_id'];

// Fetch the total number of messages sent to the logged-in user
$query = mysqli_query($conn, "
    SELECT COUNT(messages.id) AS total_messages
    FROM messages
    WHERE messages.recipient_id = '$loggedInUserId'
");

if (!$query) {
    die('Error: ' . mysqli_error($conn)); // Query failed
}

$messagesData = mysqli_fetch_assoc($query);
$totalMessages = $messagesData['total_messages'];
?>

<div class="col-lg-3 col-md-6">
<div class="card card-sm">
<div class="card-body">
<div class="d-flex justify-content-between mb-5">
<div>
<span class="d-block font-15 text-dark font-weight-500">Total Messages Received</span>
</div>
<div>
</div>
</div>
<div class="text-center">
<span class="d-block display-4 text-dark mb-5"><?php echo $totalMessages ?></span>
<small class="d-block"><?php echo "received messages"?></small>
</div>
</div>
</div>
</div>



</div>
					
            </div>
            <!-- /Container -->
        </div>
        <!-- /Main Content -->

    </div>
    <!-- /HK Wrapper -->

    <!-- jQuery -->
    <script src="vendors/jquery/dist/jquery.min.js"></script>
    <script src="vendors/popper.js/dist/umd/popper.min.js"></script>
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="dist/js/jquery.slimscroll.js"></script>
    <script src="dist/js/dropdown-bootstrap-extended.js"></script>
    <script src="dist/js/feather.min.js"></script>
    <script src="vendors/jquery-toggles/toggles.min.js"></script>
    <script src="dist/js/toggle-data.js"></script>
	<script src="vendors/waypoints/lib/jquery.waypoints.min.js"></script>
	<script src="vendors/jquery.counterup/jquery.counterup.min.js"></script>
    <script src="vendors/jquery.sparkline/dist/jquery.sparkline.min.js"></script>
    <script src="vendors/vectormap/jquery-jvectormap-2.0.3.min.js"></script>
    <script src="vendors/vectormap/jquery-jvectormap-world-mill-en.js"></script>
	<script src="dist/js/vectormap-data.js"></script>
    <script src="vendors/owl.carousel/dist/owl.carousel.min.js"></script>
    <script src="vendors/jquery-toast-plugin/dist/jquery.toast.min.js"></script>
    <script src="vendors/apexcharts/dist/apexcharts.min.js"></script>
	<script src="dist/js/irregular-data-series.js"></script>
    <script src="dist/js/init.js"></script>

   
    <script>
    var inactiveTimeout = <?php echo 30; ?>; 
    var idleTimer;

    function resetIdleTimer() {
        clearTimeout(idleTimer);
        idleTimer = setTimeout(logoutUser, inactiveTimeout * 1000);
    }

    function logoutUser() {
        window.location.href = 'auto_logout.php'; // Redirect to logout page or login page
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
<?php } ?>
