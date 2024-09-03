<?php
// Check if session is not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('includes/config.php');
require 'vendor/autoload.php'; // Autoload PHPMailer and other dependencies

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('You must be logged in to perform this action.'); window.location.href = 'login.php';</script>";
    exit();
}

$user_id = $_SESSION['user_id'];
$user_query = $conn->prepare("SELECT id, department_id, user_role FROM users WHERE id = ?");
$user_query->bind_param("i", $user_id);
$user_query->execute();
$user_result = $user_query->get_result();
$user = $user_result->fetch_assoc();

if (!$user) {
    echo "<script>alert('User not found.'); window.location.href = 'login.php';</script>";
    exit();
}

$department_id = $user['department_id'];
$user_role = $user['user_role'];

// Fetch requests for approval
$request_query = $conn->prepare("
    SELECT r.id, r.lecturer_id, r.subject_id, r.class_id, r.course, r.level, r.start_time, r.end_time, r.duration, r.day_of_week, r.status, r.reason, u.full_name AS lecturer_name
    FROM requests r
    JOIN users u ON r.lecturer_id = u.id
    WHERE r.department_id = ? AND r.status = 'pending'
");
$request_query->bind_param("i", $department_id);
$request_query->execute();
$request_result = $request_query->get_result();
$requests = $request_result->fetch_all(MYSQLI_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $request_id = $_POST['request_id'];
    $action = $_POST['action'];
    $reason = isset($_POST['reason']) ? $_POST['reason'] : '';

    if ($action == 'approve') {
        $update_query = $conn->prepare("UPDATE requests SET status = 'approved' WHERE id = ?");
        $update_query->bind_param("i", $request_id);
    } else {
        $update_query = $conn->prepare("UPDATE requests SET status = 'declined', reason = ? WHERE id = ?");
        $update_query->bind_param("si", $reason, $request_id);
    }
    $update_query->execute();

    echo "<script>alert('Request has been processed.'); window.location.href = 'request.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Request Approval</title>
</head>
<body>
    <h2>Request Approval</h2>
    <?php if ($user_role == 'HOD') : ?>
        <?php if (count($requests) > 0) : ?>
            <table>
                <tr>
                    <th>Lecturer Name</th>
                    <th>Subject</th>
                    <th>Class</th>
                    <th>Course</th>
                    <th>Level</th>
                    <th>Day</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Action</th>
                </tr>
                <?php foreach ($requests as $request) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($request['lecturer_name']); ?></td>
                        <td><?php echo htmlspecialchars($request['subject_id']); ?></td>
                        <td><?php echo htmlspecialchars($request['class_id']); ?></td>
                        <td><?php echo htmlspecialchars($request['course']); ?></td>
                        <td><?php echo htmlspecialchars($request['level']); ?></td>
                        <td><?php echo htmlspecialchars($request['day_of_week']); ?></td>
                        <td><?php echo htmlspecialchars($request['start_time']); ?></td>
                        <td><?php echo htmlspecialchars($request['end_time']); ?></td>
                        <td>
                            <form method="POST">
                                <input type="hidden" name="request_id" value="<?php echo $request['id']; ?>">
                                <button type="submit" name="action" value="approve">Approve</button>
                                <button type="submit" name="action" value="decline">Decline</button>
                                <input type="text" name="reason" placeholder="Reason (if declining)">
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else : ?>
            <p>No pending requests.</p>
        <?php endif; ?>
    <?php else : ?>
        <h3>Your Requests</h3>
        <?php
        $user_requests_query = $conn->prepare("
            SELECT r.id, r.status, r.reason, u.full_name AS lecturer_name, r.subject_id, r.class_id, r.course, r.level, r.day_of_week, r.start_time, r.end_time
            FROM requests r
            JOIN users u ON r.lecturer_id = u.id
            WHERE r.sender_id = ?
        ");
        $user_requests_query->bind_param("i", $user_id);
        $user_requests_query->execute();
        $user_requests_result = $user_requests_query->get_result();
        $user_requests = $user_requests_result->fetch_all(MYSQLI_ASSOC);
        ?>
        <?php if (count($user_requests) > 0) : ?>
            <table>
                <tr>
                    <th>Lecturer Name</th>
                    <th>Subject</th>
                    <th>Class</th>
                    <th>Course</th>
                    <th>Level</th>
                    <th>Day</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Status</th>
                    <th>Reason (if declined)</th>
                </tr>
                <?php foreach ($user_requests as $request) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($request['lecturer_name']); ?></td>
                        <td><?php echo htmlspecialchars($request['subject_id']); ?></td>
                        <td><?php echo htmlspecialchars($request['class_id']); ?></td>
                        <td><?php echo htmlspecialchars($request['course']); ?></td>
                        <td><?php echo htmlspecialchars($request['level']); ?></td>
                        <td><?php echo htmlspecialchars($request['day_of_week']); ?></td>
                        <td><?php echo htmlspecialchars($request['start_time']); ?></td>
                        <td><?php echo htmlspecialchars($request['end_time']); ?></td>
                        <td><?php echo htmlspecialchars($request['status']); ?></td>
                        <td><?php echo htmlspecialchars($request['reason']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else : ?>
            <p>No requests found.</p>
        <?php endif; ?>
    <?php endif; ?>
</body>
</html>
