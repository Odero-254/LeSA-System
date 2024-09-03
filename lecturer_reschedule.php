<?php
// Check if session is not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if ($_SESSION['user_role'] != 'Lecturer') {
    header('Location: login.php');
    exit();
}

require_once 'includes/config.php';

$lecturer_id = $_SESSION['user_id']; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['lesson_id']) && isset($_POST['new_day']) && isset($_POST['new_start_time']) && isset($_POST['new_end_time']) && isset($_POST['reason'])) {
        $lesson_id = $_POST['lesson_id'];
        $new_day = $_POST['new_day'];
        $new_start_time = $_POST['new_start_time'];
        $new_end_time = $_POST['new_end_time'];
        $reason = $_POST['reason'];

        // Insert the reschedule request
        $stmt = $conn->prepare("INSERT INTO reschedule_requests (lesson_id, lecturer_id, new_day, new_start_time, new_end_time, reason) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iissss", $lesson_id, $lecturer_id, $new_day, $new_start_time, $new_end_time, $reason);
        $stmt->execute();
        
        // Notify the class representative
        $class_rep_id = getClassRepIdForLesson($lesson_id); // Implement this function to get the class rep ID
        $message = "Lecturer has requested to reschedule lesson ID $lesson_id to $new_day $new_start_time-$new_end_time. Reason: $reason";
        $stmt = $conn->prepare("INSERT INTO messages (sender_id, recipient_id, message) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $lecturer_id, $class_rep_id, $message);
        $stmt->execute();

        echo "Reschedule request sent to class representative for approval.";
    }
}

// Fetch lessons for the lecturer
$stmt = $conn->prepare("SELECT * FROM lessons WHERE lecturer_id = ?");
$stmt->bind_param("i", $lecturer_id);
$stmt->execute();
$lessons = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reschedule Lesson</title>
</head>
<body>
    <h1>Reschedule Lesson</h1>
    <form method="post">
        <label>Lesson:</label>
        <select name="lesson_id" required>
            <?php while ($lesson = $lessons->fetch_assoc()) { ?>
                <option value="<?php echo $lesson['id']; ?>"><?php echo $lesson['lesson_name']; ?></option>
            <?php } ?>
        </select><br>
        <label>New Day:</label>
        <input type="text" name="new_day" required><br>
        <label>New Start Time:</label>
        <input type="time" name="new_start_time" required><br>
        <label>New End Time:</label>
        <input type="time" name="new_end_time" required><br>
        <label>Reason for Rescheduling:</label>
        <textarea name="reason" required></textarea><br>
        <input type="submit" value="Request Reschedule">
    </form>
</body>
</html>

<?php
function getClassRepIdForLesson($lesson_id) {
    global $conn;
    // Implement logic to fetch the class representative ID based on the lesson ID
    // This could involve joining lessons with classes and then fetching the class rep for that class
    $stmt = $conn->prepare("SELECT class_rep_id FROM classes WHERE id = (SELECT class_id FROM lessons WHERE id = ?)");
    $stmt->bind_param("i", $lesson_id);
    $stmt->execute();
    $stmt->bind_result($class_rep_id);
    $stmt->fetch();
    return $class_rep_id;
}
?>
