<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include('includes/config.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch lecturer_id
$lecturer_query = $conn->prepare("SELECT id FROM lecturers WHERE user_id = ?");
$lecturer_query->bind_param('i', $user_id);
$lecturer_query->execute();
$lecturer_result = $lecturer_query->get_result();
$lecturer_data = $lecturer_result->fetch_assoc();
$lecturer_id = $lecturer_data['id'];

// Fetch courses and classes
$allocations_query = $conn->prepare("SELECT a.course, a.class_id, c.course_name, cl.class_name FROM allocations a
    JOIN courses c ON a.course = c.id
    JOIN classes cl ON a.class_id = cl.id
    WHERE a.lecturer_id = ?");
$allocations_query->bind_param('i', $lecturer_id);
$allocations_query->execute();
$allocations_result = $allocations_query->get_result();

$courses_classes = [];
while ($row = $allocations_result->fetch_assoc()) {
    $courses_classes[] = $row;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $due_date = $_POST['due_date'];
    $course_id = $_POST['course_id'];
    $class_id = $_POST['class_id'];
    $assignment_file = $_FILES['assignment_file'];

    // Handle file upload
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($assignment_file["name"]);
    $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check file type
    if ($file_type != "doc" && $file_type != "docx" && $file_type != "pdf") {
        $message = "Only DOC, DOCX, and PDF files are allowed.";
    } else {
        if (move_uploaded_file($assignment_file["tmp_name"], $target_file)) {
            $stmt = $conn->prepare("INSERT INTO assignments (title, description, due_date, course_id, class_id, file_path) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param('sssiis', $title, $description, $due_date, $course_id, $class_id, $target_file);

            if ($stmt->execute()) {
                $message = "Assignment created successfully.";
            } else {
                $message = "Failed to create assignment.";
            }
        } else {
            $message = "Failed to upload file.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Assignment</title>
</head>
<body>

<h2>Create Assignment</h2>

<?php if (isset($message)): ?>
    <p><?php echo htmlspecialchars($message); ?></p>
<?php endif; ?>

<form method="POST" action="create_assignment.php" enctype="multipart/form-data">
    <div>
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required>
    </div>
    <div>
        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea>
    </div>
    <div>
        <label for="due_date">Due Date:</label>
        <input type="datetime-local" id="due_date" name="due_date" required>
    </div>
    <div>
        <label for="course_id">Course:</label>
        <select id="course_id" name="course_id" required>
            <option value="">Select a course</option>
            <?php foreach ($courses_classes as $cc): ?>
                <option value="<?php echo htmlspecialchars($cc['course_id']); ?>"><?php echo htmlspecialchars($cc['course_name']); ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div>
        <label for="class_id">Class:</label>
        <select id="class_id" name="class_id" required>
            <option value="">Select a class</option>
            <?php foreach ($courses_classes as $cc): ?>
                <option value="<?php echo htmlspecialchars($cc['class_id']); ?>"><?php echo htmlspecialchars($cc['class_name']); ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div>
        <label for="assignment_file">Assignment File:</label>
        <input type="file" id="assignment_file" name="assignment_file" accept=".doc,.docx,.pdf" required>
    </div>
    <button type="submit">Create Assignment</button>
</form>

</body>
</html>
