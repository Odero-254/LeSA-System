<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include('includes/config.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['assignment_id'])) {
    die("Error: Assignment ID is missing.");
}

$assignment_id = $_GET['assignment_id'];

// Fetch submissions
$submissions_query = $conn->prepare("SELECT s.id, s.submission_file, s.submitted_at, u.full_name AS student_name FROM submissions s
    JOIN students u ON s.student_id = u.id
    WHERE s.assignment_id = ?");
$submissions_query->bind_param('i', $assignment_id);
$submissions_query->execute();
$submissions_result = $submissions_query->get_result();

$submissions = [];
while ($row = $submissions_result->fetch_assoc()) {
    $submissions[] = $row;
}

// Handle grading
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $submission_id = $_POST['submission_id'];
    $grade = $_POST['grade'];
    $feedback = $_POST['feedback'];

    $stmt = $conn->prepare("UPDATE submissions SET grade = ?, feedback = ? WHERE id = ?");
    $stmt->bind_param('ssi', $grade, $feedback, $submission_id);

    if ($stmt->execute()) {
        $message = "Assignment graded successfully.";
    } else {
        $message = "Failed to grade assignment.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Grade Assignment</title>
</head>
<body>

<h2>Grade Assignment</h2>

<?php if (isset($message)): ?>
    <p><?php echo htmlspecialchars($message); ?></p>
<?php endif; ?>

<?php if (empty($submissions)): ?>
    <p>No submissions found for this assignment.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>Student Name</th>
                <th>Submission File</th>
                <th>Submitted At</th>
                <th>Grade</th>
                <th>Feedback</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($submissions as $submission): ?>
                <tr>
                    <td><?php echo htmlspecialchars($submission['student_name']); ?></td>
                    <td><a href="uploads/<?php echo htmlspecialchars($submission['submission_file']); ?>">View File</a></td>
                    <td><?php echo htmlspecialchars($submission['submitted_at']); ?></td>
                    <td>
                        <form method="POST" action="grade_assignment.php?assignment_id=<?php echo $assignment_id; ?>">
                            <input type="hidden" name="submission_id" value="<?php echo $submission['id']; ?>">
                            <input type="text" name="grade" required>
                            <textarea name="feedback" required></textarea>
                            <button type="submit">Submit Grade</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

</body>
</html>
