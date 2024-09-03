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

    // Initialize alert message variables
    $alertMessage = '';
    $alertType = '';

    // Fetch the logged-in user's class_id and department_id
    $user_id = $_SESSION['user_id'];
    $query = "SELECT class_id, department_id FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $class_id = $user['class_id'];
    $department_id = $user['department_id'];

    // Fetch subjects for the logged-in user's class
    $query = "SELECT a.id as allocation_id, s.subject_name as subject_name, a.start_time, a.end_time, a.status 
              FROM allocations a
              JOIN subjects s ON a.subject_id = s.id
              WHERE a.class_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $class_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $subjects = $result->fetch_all(MYSQLI_ASSOC);

    function updateAllocationStatus($conn, $allocation_id, $status) {
        $query = "UPDATE allocations SET status = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("si", $status, $allocation_id);
        $stmt->execute();
    }

    function sendNotification($conn, $title, $message, $allocation_id, $user_id) {
        $query = "INSERT INTO notifications (title, user_role, message, link, status, notification_time, lesson_id, user_id, sender_id, is_sent) 
                  VALUES (?, 'lecturer', ?, '', 'unread', NOW(), ?, ?, 1, 0)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssii", $title, $message, $allocation_id, $user_id);
        $stmt->execute();
    }

    // Handle automatic operations based on current time
    foreach ($subjects as $subject) {
        $current_time = date("H:i:s");
        if ($current_time > $subject['end_time'] && $subject['status'] == 'pending') {
            $allocation_id = $subject['allocation_id'];
            // Automatically mark as missed if not already marked
            updateAllocationStatus($conn, $allocation_id, 'missed');
            sendNotification($conn, 'Automatic Lesson Track', 'The lesson has been automatically marked as missed.', $allocation_id, $user_id);
            $alertMessage = 'The lesson has been automatically marked as missed.';
            $alertType = 'info';
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $allocation_id = $_POST['lesson_id'];
        $action = $_POST['action'];

        // Fetch the current status of the lesson
        $query = "SELECT status FROM allocations WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $allocation_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $allocation = $result->fetch_assoc();

        if ($allocation['status'] == 'pending') {
            if ($action == 'missed') {
                updateAllocationStatus($conn, $allocation_id, 'missed');
                $alertMessage = 'The lesson has been marked as missed.';
                $alertType = 'success';
            } elseif ($action == 'taught') {
                updateAllocationStatus($conn, $allocation_id, 'taught');
                // Redirect to student_attendance.php with only class_id
                header("Location: student_attendance.php?class_id=$class_id");
                exit();
            }
        } else {
            $alertMessage = 'This operation has already been performed for this lesson.';
            $alertType = 'warning';
        }
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Track Lesson Attendance</title>
    <link rel="shortcut icon" href="dist/img/favicon.ico">
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="dist/css/style.css" rel="stylesheet">
    <script>
        function markAttendance(lesson_id, action) {
            if (action === 'taught') {
                // Redirect to student_attendance.php with only class_id
                window.location.href = 'student_attendance.php?class_id=<?php echo $class_id; ?>';
            } else {
                var form = document.createElement('form');
                form.method = 'POST';
                form.action = 'track_attendance.php';

                var lessonInput = document.createElement('input');
                lessonInput.type = 'hidden';
                lessonInput.name = 'lesson_id';
                lessonInput.value = lesson_id;
                form.appendChild(lessonInput);

                var actionInput = document.createElement('input');
                actionInput.type = 'hidden';
                actionInput.name = 'action';
                actionInput.value = action;
                form.appendChild(actionInput);

                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
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
                    <li class="breadcrumb-item"><a href="dashboard_cRep.php">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Track Lesson Attendance</li>
                </ol>
            </nav>
            <!-- /Breadcrumb -->

            <!-- Container -->
            <div class="container">
                <!-- Title -->
                <div class="hk-pg-header">
                    <h4 class="hk-pg-title">
                        <span class="pg-title-icon">
                            <span class="feather-icon">
                                <i data-feather="external-link"></i>
                            </span>
                        </span>
                        Track Lesson Attendance
                    </h4>
                </div>
                <!-- /Title -->
                <div class="row">
                    <div class="col-xl-12">
                        <section class="hk-sec-wrapper">
                            <div class="container mt-4">
                                <!-- Alert Messages -->
                                <?php if (!empty($alertMessage)) { ?>
                                    <div class="alert alert-<?php echo $alertType; ?>" role="alert">
                                        <?php echo $alertMessage; ?>
                                    </div>
                                <?php } ?>

                                <h2>Track Attendance for Today's Lessons</h2>

                                <!-- Loop through the lessons and display details -->
                                <?php if (!empty($subjects)) { ?>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Subject Name</th>
                                                    <th>Start Time</th>
                                                    <th>End Time</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($subjects as $subject) { ?>
                                                    <tr>
                                                        <td><?php echo htmlspecialchars($subject['subject_name']); ?></td>
                                                        <td><?php echo htmlspecialchars($subject['start_time']); ?></td>
                                                        <td><?php echo htmlspecialchars($subject['end_time']); ?></td>
                                                        <td><?php echo htmlspecialchars($subject['status']); ?></td>
                                                        <td>
                                                            <?php if ($subject['status'] == 'pending') { ?>
                                                                <button class="btn btn-success btn-sm" onclick="markAttendance(<?php echo $subject['allocation_id']; ?>, 'taught')">Mark as Taught</button>
                                                                <button class="btn btn-danger btn-sm" onclick="markAttendance(<?php echo $subject['allocation_id']; ?>, 'missed')">Mark as Missed</button>
                                                            <?php } else { ?>
                                                                <span><?php echo ucfirst($subject['status']); ?></span>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php } else { ?>
                                    <div class="alert alert-info" role="alert">
                                        No lessons found for today.
                                    </div>
                                <?php } ?>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
            <!-- /Container -->
        </div>
        <!-- /Main Content -->

    </div>
    <!-- /HK Wrapper -->

    <!-- Scripts -->
    <script src="vendors/jquery/dist/jquery.min.js"></script>
    <script src="vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="dist/js/feather.min.js"></script>
    <script src="dist/js/init.js"></script>

</body>

</html>
<?php } ?>
