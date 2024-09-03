<?php
// Check if session is not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if ($_SESSION['user_role'] != 'Class Representative') {
    header('Location: login.php');
    exit();
}

require_once 'includes/config.php';

$class_id = $_SESSION['class_id']; 
$current_time = date('H:i:s');
$current_day = date('l');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['lesson_id']) && isset($_POST['status'])) {
        $lesson_id = $_POST['lesson_id'];
        $status = $_POST['status'];

        // Check if the lesson time is within the allowed time frame
        $stmt = $conn->prepare("SELECT start_time FROM lessons WHERE id = ?");
        $stmt->bind_param("i", $lesson_id);
        $stmt->execute();
        $stmt->bind_result($start_time);
        $stmt->fetch();
        $stmt->close();

        $start_time = strtotime($start_time);
        $current_time = strtotime($current_time);
        $allowed_time = $start_time + (20 * 60); // 20 minutes after start time

        if ($current_time >= $start_time && $current_time <= $allowed_time) {
            // Mark the lesson as attended or missed
            $stmt = $conn->prepare("INSERT INTO attendance (lesson_id, status) VALUES (?, ?)");
            $stmt->bind_param("is", $lesson_id, $status);
            $stmt->execute();

            if ($status == 'attended') {
                header('Location: mark_absent_students.php?lesson_id=' . $lesson_id);
                exit();
            }
        } else {
            echo "You can only mark the lesson within 20 minutes after the start time.";
        }
    }
}

// Automatically mark missed lessons
$stmt = $conn->prepare("
    SELECT id FROM lessons 
    WHERE class_id = ? AND day_of_week = ? AND start_time < ? AND id NOT IN 
    (SELECT lesson_id FROM attendance)
");
$stmt->bind_param("iss", $class_id, $current_day, $current_time);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $lesson_id = $row['id'];
    $stmt2 = $conn->prepare("INSERT INTO attendance (lesson_id, status) VALUES (?, 'missed')");
    $stmt2->bind_param("i", $lesson_id);
    $stmt2->execute();
}
$stmt->close();

// Fetch today's lessons
$stmt = $conn->prepare("SELECT * FROM lessons WHERE class_id = ? AND day_of_week = ?");
$stmt->bind_param("is", $class_id, $current_day);
$stmt->execute();
$lessons = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Class Representative Page</title>
    <link rel="shortcut icon" href="dist/img/favicon.ico">
</head>
<body>
    <h1>Class Timetable for <?php echo $current_day; ?></h1>
    <table>
        <tr>
            <th>Lesson Name</th>
            <th>Start Time</th>
            <th>End Time</th>
            <th>Status</th>
        </tr>
        <?php while ($lesson = $lessons->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $lesson['lesson_name']; ?></td>
            <td><?php echo $lesson['start_time']; ?></td>
            <td><?php echo $lesson['end_time']; ?></td>
            <td>
                <form method="post">
                    <input type="hidden" name="lesson_id" value="<?php echo $lesson['id']; ?>">
                    <button type="submit" name="status" value="attended">Attended</button>
                    <button type="submit" name="status" value="missed">Missed</button>
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
