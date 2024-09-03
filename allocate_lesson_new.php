<?php
// Check if session is not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include 'includes/config.php';

function allocateLesson($lessonName, $lecturerId, $classId, $startTime, $endTime, $repeatUntil) {
    global $conn;

    // Fetch the current academic term dates
    $termSql = "SELECT start_date, end_date FROM academic_terms ORDER BY id DESC LIMIT 1";
    $termResult = $conn->query($termSql);
    $term = $termResult->fetch_assoc();

    if (!$term || strtotime($startTime) < strtotime($term['start_date']) || strtotime($repeatUntil) > strtotime($term['end_date'])) {
        return ['status' => 'error', 'message' => 'Lesson allocation must be within the current academic term dates.'];
    }

    $sql = "INSERT INTO lessons (lesson_name, lecturer_id, class_id, start_time, end_time, repeat_until)
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siisss", $lessonName, $lecturerId, $classId, $startTime, $endTime, $repeatUntil);
    $stmt->execute();
    $lessonId = $stmt->insert_id;
    $stmt->close();

    $notificationResponse = createNotifications($lessonId, $lecturerId, $classId, $startTime);

    if ($notificationResponse['status'] === 'success') {
        return ['status' => 'success', 'message' => 'Lesson allocated successfully.'];
    } else {
        return $notificationResponse;
    }
}

function createNotifications($lessonId, $lecturerId, $classId, $startTime) {
    global $conn;

    $notificationTime = date('Y-m-d H:i:s', strtotime('-1 hour', strtotime($startTime)));
    
    $sql = "INSERT INTO notifications (lesson_id, user_id, notification_time)
            VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis", $lessonId, $lecturerId, $notificationTime);
    $stmt->execute();
    
    $repSql = "SELECT id FROM users WHERE class_id = ? AND role_id = 2";
    $repStmt = $conn->prepare($repSql);
    $repStmt->bind_param("i", $classId);
    $repStmt->execute();
    $repResult = $repStmt->get_result();
    
    while ($repRow = $repResult->fetch_assoc()) {
        $stmt->bind_param("iis", $lessonId, $repRow['id'], $notificationTime);
        $stmt->execute();
    }
    
    $stmt->close();
    $repStmt->close();

    return ['status' => 'success'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $lessonName = $_POST['lesson_name'];
    $lecturerId = $_POST['lecturer_id'];
    $classId = $_POST['class_id'];
    $startTime = $_POST['start_time'];
    $endTime = $_POST['end_time'];
    $repeatUntil = $_POST['repeat_until'];

    $response = allocateLesson($lessonName, $lecturerId, $classId, $startTime, $endTime, $repeatUntil);

    header('Content-Type: application/json');
    echo json_encode($response);
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Allocate Lesson</title>
</head>
<body>
    <h1>Allocate Lesson</h1>
    <form id="allocateLessonForm">
        <label for="lesson_name">Lesson Name:</label><br>
        <input type="text" id="lesson_name" name="lesson_name" required><br><br>
        <label for="lecturer_id">Lecturer ID:</label><br>
        <input type="number" id="lecturer_id" name="lecturer_id" required><br><br>
        <label for="class_id">Class ID:</label><br>
        <input type="number" id="class_id" name="class_id" required><br><br>
        <label for="start_time">Start Time:</label><br>
        <input type="datetime-local" id="start_time" name="start_time" required><br><br>
        <label for="end_time">End Time:</label><br>
        <input type="datetime-local" id="end_time" name="end_time" required><br><br>
        <label for="repeat_until">Repeat Until:</label><br>
        <input type="date" id="repeat_until" name="repeat_until" required><br><br>
        <button type="submit">Allocate Lesson</button>
    </form>

    <script>
    document.getElementById('allocateLessonForm').addEventListener('submit', function(event) {
        event.preventDefault();

        const formData = new FormData(this);

        fetch('/path/to/allocate_lesson.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
        })
        .catch(error => console.error('Error:', error));
    });
    </script>
</body>
</html>
