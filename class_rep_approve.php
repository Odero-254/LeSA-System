<?php

// Check if session is not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if ($_SESSION['user_role'] != 'ClassRepresentative') {
    header('Location: login.php');
    exit();
}

require_once 'includes/config.php';

$class_rep_id = $_SESSION['user_id']; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['request_id']) && isset($_POST['status']) && isset($_POST['reason'])) {
        $request_id = $_POST['request_id'];
        $status = $_POST['status'];
        $reason = $_POST['reason'];

        // Update the reschedule request status
        $stmt = $conn->prepare("UPDATE reschedule_requests SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $request_id);
        $stmt->execute();

        // Fetch request details for notification
        $stmt = $conn->prepare("SELECT lesson_id, lecturer_id, new_day, new_start_time, new_end_time, reason FROM reschedule_requests WHERE id = ?");
        $stmt->bind_param("i", $request_id);
        $stmt->execute();
        $stmt->bind_result($lesson_id, $lecturer_id, $new_day, $new_start_time, $new_end_time, $reason);
        $stmt->fetch();

        // Notify the lecturer
        $message = "Your reschedule request for lesson ID $lesson_id has been $status. Reason: $reason";
        $stmt = $conn->prepare("INSERT INTO messages (sender_id, recipient_id, message) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $class_rep_id, $lecturer_id, $message);
        $stmt->execute();

        if ($status == 'approved') {
            // Notify HOD, Principal, and Deputy Principal
            $recipients = getStakeholders(); // Implement this function to get the HOD, Principal, and Deputy Principal IDs
            foreach ($recipients as $recipient_id) {
                $message = "Rescheduled Lesson: $lesson_id, Lecturer: $lecturer_id, New Time: $new_day $new_start_time-$new_end_time, Reason: $reason";
                $stmt = $conn->prepare("INSERT INTO messages (sender_id, recipient_id, message) VALUES (?, ?, ?)");
                $stmt->bind_param("iis", $class_rep_id, $recipient_id, $message);
                $stmt->execute();
            }
        }
    }
}

// Fetch pending reschedule requests
$stmt = $conn->prepare("
    SELECT r.id, r.lesson_id, l.lesson_name, r.new_day, r.new_start_time, r.new_end_time, r.reason
    FROM reschedule_requests r
    JOIN lessons l ON r.lesson_id = l.id
    WHERE r.status = 'pending' AND l.class_id = (SELECT class_id FROM class_representatives WHERE user_id = ?)
");
$stmt->bind_param("i", $class_rep_id);
$stmt->execute();
$requests = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Approve Reschedule Requests</title>
    <link rel="shortcut icon" href="dist/img/favicon.ico">
</head>
<body>
    <h1>Approve Reschedule Requests</h1>
    <form method="post">
        <?php while ($request = $requests->fetch_assoc()) { ?>
            <div>
                <p>Lesson: <?php echo $request['lesson_name']; ?></p>
                <p>New Day: <?php echo $request['new_day']; ?></p>
                <p>New Time: <?php echo $request['new_start_time']; ?> - <?php echo $request['new_end_time']; ?></p>
                <p>Reason: <?php echo $request['reason']; ?></p>
                <input type="hidden" name="request_id" value="<?php echo $request['id']; ?>">
                <label>Approval Status:</label>
                <select name="status" required>
                    <option value="approved">Approved</option>
                    <option value="rejected">Rejected</option>
                </select><br>
                <label>Reason for Rejection:</label>
                <textarea name="reason" required></textarea><br>
            </div>
            <hr>
        <?php } ?>
        <input type="submit" value="Submit Approval or Rejection">
    </form>
</body>
</html>
<?php
function getStakeholders() {
    global $conn;
    // Implement logic to fetch HOD, Principal, and Deputy Principal IDs
    $stmt = $conn->prepare("SELECT user_id FROM users WHERE user_role IN ('HOD', 'Principal', 'Deputy Principal')");
    $stmt->execute();
    $result = $stmt->get_result();
    $recipients = array();
    while ($row = $result->fetch_assoc()) {
        $recipients[] = $row['user_id'];
    }
    return $recipients;
}
?>
