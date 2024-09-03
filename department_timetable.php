<?php
// Check if session is not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
//error_reporting(0);
include('includes/config.php');

if (strlen($_SESSION['user_id']) == 0) {
    header('location:logout.php');
} else {
    // Update last activity time to extend session
    $_SESSION['last_active_time'] = time();
}

function getTimetableData($conn) {
    $sql = "SELECT departments.name AS department, allocations.day, allocations.start_time, allocations.end_time, subjects.name AS subject, lecturers.name AS lecturer
            FROM allocations
            JOIN subjects ON allocations.subject_id = subjects.id
            JOIN lecturers ON allocations.lecturer_id = lecturers.id
            JOIN departments ON subjects.department_id = departments.id";
    $result = $conn->query($sql);

    $timetable = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $timetable[$row['department']][$row['day']][] = $row;
        }
    }
    return $timetable;
}

$timetableData = getTimetableData($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Comprehensive Timetable</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<h2>Comprehensive Class Timetable</h2>

<?php
$times = [
    "8:30AM - 10:00AM",
    "10:15AM - 12:15PM",
    "1:15PM - 3:15PM",
    "3:30PM - 5:30PM",
];

$days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday"];

foreach ($timetableData as $department => $schedule) {
    echo "<h3>$department</h3>";
    echo "<table>";
    echo "<tr>
            <th>Time</th>
            <th>Monday</th>
            <th>Tuesday</th>
            <th>Wednesday</th>
            <th>Thursday</th>
            <th>Friday</th>
          </tr>";

    foreach ($times as $time) {
        echo "<tr>";
        echo "<td>$time</td>";
        foreach ($days as $day) {
            echo "<td>";
            if (isset($schedule[$day])) {
                foreach ($schedule[$day] as $lesson) {
                    if (strpos($time, date("g:iA", strtotime($lesson['start_time']))) !== false) {
                        echo $lesson['subject'] . "<br>" . $lesson['lecturer'];
                    }
                }
            }
            echo "</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
}
?>

<script>
    var inactiveTimeout = <?php echo 60; ?>;
    var idleTimer;

    function resetIdleTimer() {
        clearTimeout(idleTimer);
        idleTimer = setTimeout(logoutUser, inactiveTimeout * 1000);
    }

    function logoutUser() {
        window.location.href = 'logout.php'; // Redirect to logout page or login page
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

<?php $conn->close(); ?>
