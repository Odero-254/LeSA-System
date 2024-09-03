<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include('includes/config.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch assignments
$assignments_query = $conn->prepare("SELECT a.id, a.title, a.description, a.due_date, c.course_name, cl.class_name FROM assignments a 
    JOIN courses c ON a.course_id = c.id 
    JOIN classes cl ON a.class_id = cl.id");
$assignments_query->execute();
$assignments_result = $assignments_query->get_result();

$assignments = [];
while ($row = $assignments_result->fetch_assoc()) {
    $assignments[] = $row;
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
    <title>View Assignments</title>
</head>
<body>

<h2>View Assignments</h2>

<?php if (isset($message)): ?>
    <p><?php echo htmlspecialchars($message); ?></p>
<?php endif; ?>

<table>
    <thead>
        <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Due Date</th>
            <th>Course Name</th>
            <th>Class Name</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($assignments as $assignment): ?>
            <tr>
                <td><?php echo htmlspecialchars($assignment['title']); ?></td>
                <td><?php echo htmlspecialchars($assignment['description']); ?></td>
                <td><?php echo htmlspecialchars($assignment['due_date']); ?></td>
                <td><?php echo htmlspecialchars($assignment['course_name']); ?></td>
                <td><?php echo htmlspecialchars($assignment['class_name']); ?></td>
                <td>
                    <a href="grade_assignment.php?assignment_id=<?php echo $assignment['id']; ?>">Grade</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>
