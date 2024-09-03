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

// Fetch user details
$user_query = $conn->prepare("SELECT department_id FROM users WHERE id = ?");
$user_query->bind_param('i', $user_id);
$user_query->execute();
$user_result = $user_query->get_result();
$user_data = $user_result->fetch_assoc();
$department_id = $user_data['department_id'];

// Fetch courses and classes
$courses_query = $conn->prepare("SELECT id, course_name FROM courses WHERE department_id = ?");
$courses_query->bind_param('i', $department_id);
$courses_query->execute();
$courses_result = $courses_query->get_result();

$classes_query = $conn->prepare("SELECT id, class_name, course_id FROM classes WHERE department_id = ?");
$classes_query->bind_param('i', $department_id);
$classes_query->execute();
$classes_result = $classes_query->get_result();

$courses = [];
$classes = [];

while ($course_row = $courses_result->fetch_assoc()) {
    $courses[] = $course_row;
}

while ($class_row = $classes_result->fetch_assoc()) {
    $classes[] = $class_row;
}

$students = [];
$no_students_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $selected_course_id = $_POST['course_id'];
    $selected_class_id = $_POST['class_id'];

    $students_query = $conn->prepare("SELECT * FROM students WHERE course_id = ? AND class_id = ?");
    $students_query->bind_param('ii', $selected_course_id, $selected_class_id);
    $students_query->execute();
    $students_result = $students_query->get_result();

    while ($student_row = $students_result->fetch_assoc()) {
        $students[] = $student_row;
    }

    if (empty($students)) {
        $no_students_message = 'No students found for the selected class and course.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>LeSAS | My Students</title>
    <link rel="stylesheet" href="path/to/your/css/style.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .alert {
            padding: 10px;
            background-color: #f44336; /* Red */
            color: white;
            margin-bottom: 15px;
        }

        .alert.success {background-color: #4CAF50;} /* Green */
        .alert.info {background-color: #2196F3;} /* Blue */
        .alert.warning {background-color: #fa164c;} /* Orange */
    </style>
</head>
<body>

<div class="container">
    <h2>My Students</h2>

    <form method="POST" action="my_students.php">
        <div class="form-group">
            <label for="course_id">Course Name:</label>
            <select name="course_id" id="course_id" required>
                <option value="">Select a course</option>
                <?php foreach ($courses as $course): ?>
                    <option value="<?php echo htmlspecialchars($course['id']); ?>"><?php echo htmlspecialchars($course['course_name']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="class_id">Class Name:</label>
            <select name="class_id" id="class_id" required>
                <option value="">Select a class</option>
                <?php foreach ($classes as $class): ?>
                    <option value="<?php echo htmlspecialchars($class['id']); ?>"><?php echo htmlspecialchars($class['class_name']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit">View Students</button>
    </form>

    <?php if (!empty($no_students_message)): ?>
        <div class="alert warning"><?php echo $no_students_message; ?></div>
    <?php endif; ?>

    <?php if (!empty($students)): ?>
        <h3>Student List</h3>
        <table>
            <thead>
                <tr>
                    <th>Service Number</th>
                    <th>Full Name</th>
                    <th>Phone Number</th>
                    <th>Email Address</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $student): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($student['servNo']); ?></td>
                        <td><?php echo htmlspecialchars($student['name']); ?></td>
                        <td><?php echo htmlspecialchars($student['phone']); ?></td>
                        <td><?php echo htmlspecialchars($student['email']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

</body>
</html>
