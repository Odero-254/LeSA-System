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

// Fetch absent students from the database
$query = "
    SELECT 
        sa.id, st.name, c.class_name, s.subject_name AS subject_name, sa.start_time, sa.end_time, sa.day_of_the_week
    FROM 
        student_absence sa
    JOIN 
        students st ON sa.student_id = st.id
    JOIN 
        classes c ON sa.class_id = c.id
    JOIN 
        subjects s ON sa.subject_id = s.id
";
$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Absent Students</title>
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
    <h1>Absent Students Report</h1>
    
    <?php if (mysqli_num_rows($result) > 0): ?>
    <table>
        <thead class="table-header">
            <tr>
                <th>Student Name</th>
                <th>Class Name</th>
                <th>Subject Name</th>
                <th>Lesson Time</th>
                <th>Day</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo $row['full_name']; ?></td>
                <td><?php echo $row['class_name']; ?></td>
                <td><?php echo $row['subject_name']; ?></td>
                <td><?php echo $row['start_time'] . ' - ' . $row['end_time']; ?></td>
                <td><?php echo $row['day_of_the_week']; ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <?php else: ?>
    <p class="error-message">No absent students found.</p>
    <?php endif; ?>

    <a href="javascript:history.back()" class="back-button">
        <i class="fas fa-arrow-left"></i>Back
    </a>

</body>
</html>

<?php
ob_end_flush(); // Flush the output buffer
?>
