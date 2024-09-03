<?php

require_once 'includes/config.php';

function generateTimetable($conn, $filter = null) {
    $query = "SELECT 
                allocations.day, 
                allocations.start_time, 
                allocations.end_time, 
                subjects.name AS subject_name, 
                lecturers.name AS lecturer_name,
                classes.id AS class_id
              FROM allocations 
              JOIN subjects ON allocations.subject_id = subjects.id 
              JOIN lecturers ON allocations.lecturer_id = lecturers.id 
              JOIN classes ON allocations.class_id = classes.id";
    
    if ($filter) {
        $query .= " WHERE $filter";
    }
    
    $query .= " ORDER BY allocations.day, allocations.start_time";
    $result = $conn->query($query);

    $timetable = [];
    while ($row = $result->fetch_assoc()) {
        $timetable[] = $row;
    }
    return $timetable;
}

// Display timetable
$timetable = generateTimetable($conn);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Timetable</title>
    <link rel="shortcut icon" href="dist/img/favicon.ico">
</head>
<body>
    <h1>Timetable</h1>
    <table border="1">
        <thead>
            <tr>
                <th>Day</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Subject</th>
                <th>Lecturer</th>
                <th>Class ID</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($timetable as $entry): ?>
                <tr>
                    <td><?= $entry['day'] ?></td>
                    <td><?= $entry['start_time'] ?></td>
                    <td><?= $entry['end_time'] ?></td>
                    <td><?= $entry['subject_name'] ?></td>
                    <td><?= $entry['lecturer_name'] ?></td>
                    <td><?= $entry['class_id'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
