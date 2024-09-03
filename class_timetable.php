<?php
// Check if session is not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require 'includes/config.php';

// Ensure the user is logged in
if (empty($_SESSION['user_id'])) {
    header('location:logout.php');
    exit();
} else {
    // Update last activity time to extend session
    $_SESSION['last_active_time'] = time();
}

// Function to get timetable data
function getTimetableData($conn, $class_id) {
    $sql = "SELECT allocations.day_of_week, allocations.start_time, allocations.end_time, subjects.subject_name as subject, lecturers.username as lecturer
            FROM allocations
            JOIN subjects ON allocations.subject_id = subjects.id
            JOIN lecturers ON allocations.lecturer_id = lecturers.id
            WHERE allocations.class_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $class_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $timetable = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $timetable[$row['day_of_week']][] = $row;
        }
    }
    $stmt->close();
    return $timetable;
}

// Fetch class and department information
$user_id = $_SESSION['user_id'];
$sql = "SELECT u.class_id, u.department_id, c.class_name, d.name as department_name
        FROM users u
        JOIN classes c ON u.class_id = c.id
        JOIN department d ON u.department_id = d.id
        WHERE u.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user_info = $result->fetch_assoc();
$stmt->close();

$class_id = $user_info['class_id'];
$class_name = $user_info['class_name'];
$department_name = $user_info['department_name'];

// Fetch timetable data for the logged-in user's class
$timetableData = getTimetableData($conn, $class_id);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Class Timetable</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1, .header h2, .header h3, .header h4 {
            margin: 5px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            overflow-x: auto; /* Enable horizontal scrolling if needed */
            display: block;
            max-width: 100%;
            margin: 0 auto; /* Center the table horizontally */
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        @media (max-width: 768px) {
            table {
                width: 100%;
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }
            th, td {
                display: inline-block;
                width: auto;
                text-align: left;
            }
        }
    </style>
</head>
<body>


<div class="header">
    <h3>National Youth Service</h3>
    <h4>Engineering Institute</h4>
    <h5>Class Timetable</h5>
    <p><strong>The Class:</strong> <?php echo htmlspecialchars($class_name); ?></p>
    <p><strong>The Department:</strong> <?php echo htmlspecialchars($department_name); ?></p>
</div>

<table>
    <thead>
        <tr>
            <th>Time</th>
            <th>Monday</th>
            <th>Tuesday</th>
            <th>Wednesday</th>
            <th>Thursday</th>
            <th>Friday</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $times = [
            "8:00AM - 10:00AM",
            "10:15AM - 12:15PM",
            "1:15PM - 3:15PM",
            "3:30PM - 5:30PM",
        ];

        $days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday"];

        foreach ($times as $time) {
            echo "<tr>";
            echo "<td>$time</td>";
            foreach ($days as $day) {
                echo "<td>";
                if (isset($timetableData[$day])) {
                    foreach ($timetableData[$day] as $lesson) {
                        if (strpos($time, date("g:iA", strtotime($lesson['start_time']))) !== false) {
                            echo htmlspecialchars($lesson['subject']) . "<br>" . htmlspecialchars($lesson['lecturer']);
                        }
                    }
                }
                echo "</td>";
            }
            echo "</tr>";
        }
        ?>
    </tbody>
</table>

<script>
    var inactiveTimeout = <?php echo 300; ?>; 
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
