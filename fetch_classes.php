<?php
// Check if session is not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('includes/config.php');

// Check if course_id and level_id are set
if (isset($_GET['course_id']) && isset($_GET['level_id'])) {
    $course_id = $conn->real_escape_string($_GET['course_id']);
    $level_id = $conn->real_escape_string($_GET['level_id']);

    // Query to fetch classes based on course_id and level_id
    $query = "
        SELECT c.id, c.class_name
        FROM classes c
        WHERE c.course_id = '$course_id' AND c.level_id = '$level_id'
    ";

    $result = $conn->query($query);

    $classes = array();
    while ($row = $result->fetch_assoc()) {
        $classes[] = $row;
    }

    echo json_encode($classes);
}
?>
