<?php
// Start the session
session_start();

// Include the database configuration file
require_once 'includes/config.php';

// Initialize alert messages
$alertMessage = '';
$alertType = '';

// Assuming you have a session variable storing the logged-in user's ID
$loggedInUserId = $_SESSION['user_id'];

// Fetch the logged-in user's class_id
$userQuery = "SELECT class_id FROM users WHERE id = '$loggedInUserId'";
$userResult = mysqli_query($conn, $userQuery);
$userRow = mysqli_fetch_assoc($userResult);
$loggedInUserClassId = $userRow['class_id'];

// Fetch students who have lessons today and whose class_id matches the logged-in user's class_id
$query = "SELECT s.id AS student_id, s.name, c.class_name, sub.id AS subject_id, sub.subject_name AS subject_name, 
                 al.course, al.start_time, al.end_time, al.day_of_week, c.id AS class_id
          FROM students s
          JOIN classes c ON s.class_id = c.id
          JOIN allocations al ON al.class_id = c.id
          JOIN subjects sub ON al.subject_id = sub.id
          WHERE al.day_of_week = DAYNAME(CURDATE())
          AND s.class_id = '$loggedInUserClassId'";

$result = mysqli_query($conn, $query);

// Handle marking a student as absent
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['mark_absent'])) {
    $studentId = $_POST['student_id'];
    $subjectId = $_POST['subject_id'];
    $classId = $_POST['class_id'];
    $courseId = $_POST['course_id'];
    $startTime = $_POST['start_time'];
    $endTime = $_POST['end_time'];
    $dayOfWeek = $_POST['day_of_week'];

    // Insert absent student details into the student_absence table
    $insertQuery = "INSERT INTO student_absence (student_id, subject_id, class_id, course_id, start_time, end_time, day_of_week) 
                    VALUES ('$studentId', '$subjectId', '$classId', '$courseId', '$startTime', '$endTime', '$dayOfWeek')";

    if (mysqli_query($conn, $insertQuery)) {
        $alertMessage = "Student marked as absent successfully.";
        $alertType = "success";
    } else {
        $alertMessage = "Error marking student as absent: " . mysqli_error($conn);
        $alertType = "danger";
    }
}

// Handle completing the attendance process
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['complete_attendance'])) {
    // Save subject attendance details here (not shown in detail, adjust according to your needs)
    // Redirect or perform additional actions if necessary

    $alertMessage = "Attendance process completed.";
    $alertType = "success";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Attendance</title>
    <link rel="stylesheet" href="vendors/bootstrap/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2>Student Attendance for Today's Lessons</h2>

    <!-- Display alert messages -->
    <?php if (!empty($alertMessage)) { ?>
        <div class="alert alert-<?php echo htmlspecialchars($alertType); ?>" role="alert">
            <?php echo htmlspecialchars($alertMessage); ?>
        </div>
    <?php } ?>

    <!-- Display student details -->
    <?php if (mysqli_num_rows($result) > 0) { ?>
        <form method="post" action="">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Student Name</th>
                        <th>Class</th>
                        <th>Subject</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['class_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['subject_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['start_time']); ?></td>
                            <td><?php echo htmlspecialchars($row['end_time']); ?></td>
                            <td>
                                <button type="submit" name="mark_absent" class="btn btn-danger btn-sm"
                                        value="Mark Absent">
                                    Mark Absent
                                </button>
                                <input type="hidden" name="student_id" value="<?php echo htmlspecialchars($row['student_id']); ?>">
                                <input type="hidden" name="subject_id" value="<?php echo htmlspecialchars($row['subject_id']); ?>">
                                <input type="hidden" name="class_id" value="<?php echo htmlspecialchars($row['class_id']); ?>">
                                <input type="hidden" name="course_id" value="<?php echo htmlspecialchars($row['course']); ?>">
                                <input type="hidden" name="start_time" value="<?php echo htmlspecialchars($row['start_time']); ?>">
                                <input type="hidden" name="end_time" value="<?php echo htmlspecialchars($row['end_time']); ?>">
                                <input type="hidden" name="day_of_week" value="<?php echo htmlspecialchars($row['day_of_week']); ?>">
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

            <button type="submit" name="complete_attendance" class="btn btn-primary">Complete Attendance</button>
        </form>
    <?php } else { ?>
        <p>No students available for attendance tracking.</p>
    <?php } ?>
</div>

<!-- jQuery -->
<script src="vendors/jquery/dist/jquery.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>

</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
