<?php
// Check if session is not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if ($_SESSION['user_role'] != 'ClassRep') {
    header('Location: login.php');
    exit();
}

require_once 'includes/config.php';

$lesson_id = $_GET['lesson_id'];
$class_id = $_SESSION['class_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['student_id']) && isset($_POST['status'])) {
        foreach ($_POST['student_id'] as $student_id) {
            $status = $_POST['status'][$student_id];
            $stmt = $conn->prepare("INSERT INTO student_absence (student_id, lesson_id, status) VALUES (?, ?, ?)");
            $stmt->bind_param("iis", $student_id, $lesson_id, $status);
            $stmt->execute();
        }
        echo "Attendance recorded successfully.";
    }
}

// Fetch students in the class
$stmt = $conn->prepare("SELECT * FROM students WHERE class_id = ?");
$stmt->bind_param("i", $class_id);
$stmt->execute();
$students = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Mark Absent Students</title>
</head>
<body>
    <h1>Mark Absent Students for Lesson ID: <?php echo $lesson_id; ?></h1>
    <form method="post">
        <table>
            <tr>
                <th>Student Name</th>
                <th>Status</th>
            </tr>
            <?php while ($student = $students->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $student['name']; ?></td>
                <td>
                    <input type="hidden" name="student_id[]" value="<?php echo $student['id']; ?>">
                    <select name="status[<?php echo $student['id']; ?>]">
                        <option value="present">Present</option>
                        <option value="absent">Absent</option>
                    </select>
                </td>
            </tr>
            <?php } ?>
        </table>
        <button type="submit">Submit Attendance</button>
    </form>
</body>
</html>
