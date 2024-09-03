<?php
ob_start(); // Start output buffering

include('includes/config.php');
// Check if session is not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Fetch subject allocations from the database
$query = "
    SELECT 
        a.id, l.username AS lecturer_name, s.subject_name AS subject_name, c.class_name, a.course, a.level, a.start_time, a.end_time, a.day_of_week
    FROM 
        allocations a
    JOIN 
        lecturers l ON a.lecturer_id = l.id
    JOIN 
        subjects s ON a.subject_id = s.id
    JOIN 
        classes c ON a.class_id = c.id
";
$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Subject Allocations</title>
    <style>
        /* Add your custom styles here */
        .table-header {
            background-color: lightblue;
        }
        .error-message {
            color: red;
        }
    </style>
</head>
<body>
    <h1>Subject Allocations Report</h1>
    
    <?php if (mysqli_num_rows($result) > 0): ?>
    <table>
        <thead class="table-header">
            <tr>
                <th>Lecturer Name</th>
                <th>Subject Name</th>
                <th>Class Name</th>
                <th>Course</th>
                <th>Level</th>
                <th>Lesson Time</th>
                <th>Day</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo $row['lecturer_name']; ?></td>
                <td><?php echo $row['subject_name']; ?></td>
                <td><?php echo $row['class_name']; ?></td>
                <td><?php echo $row['course']; ?></td>
                <td><?php echo $row['level']; ?></td>
                <td><?php echo $row['start_time'] . ' - ' . $row['end_time']; ?></td>
                <td><?php echo $row['day_of_week']; ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <?php else: ?>
    <p class="error-message">No subject allocations found.</p>
    <?php endif; ?>

    <a href="javascript:history.back()" class="back-button">
                    <i class="fas fa-arrow-left"></i>Back
    </a>
</body>
</html>

<?php
ob_end_flush(); // Flush the output buffer
?>
