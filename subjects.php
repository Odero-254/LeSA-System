<?php
// Check if session is not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once 'includes/config.php'; 
// Check if user is logged in and has the necessary role
if (!isset($_SESSION['user_id'], $_SESSION['user_role']) || !in_array($_SESSION['user_role'], ['Principal', 'Deputy Principal', 'HOD'])) {
    header("Location: unauthorized.php");
    exit();
}

// Fetch subjects from the database
$sql = "SELECT id, name, course_id, level_id, qualifications FROM subjects";
$result = $conn->query($sql);

// Initialize an array to store subjects
$subjects = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $subjects[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Subjects List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table th, table td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
        table th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Subjects List</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Course ID</th>
                    <th>Level ID</th>
                    <th>Qualifications</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($subjects as $subject): ?>
                    <tr>
                        <td><?php echo $subject['id']; ?></td>
                        <td><?php echo $subject['name']; ?></td>
                        <td><?php echo $subject['course_id']; ?></td>
                        <td><?php echo $subject['level_id']; ?></td>
                        <td><?php echo $subject['qualifications']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
