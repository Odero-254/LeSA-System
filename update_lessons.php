<?php
include 'includes/config.php';

function updateLessons() {
    global $conn;

    // Fetch the current academic term dates
    $termSql = "SELECT start_date, end_date FROM academic_terms ORDER BY id DESC LIMIT 1";
    $termResult = $conn->query($termSql);
    $term = $termResult->fetch_assoc();

    if (!$term) {
        return ['status' => 'error', 'message' => 'No academic term set.'];
    }

    $sql = "SELECT * FROM lessons WHERE start_time <= NOW() AND repeat_until >= CURDATE()";
    $result = $conn->query($sql);

    while ($row = $result->fetch_assoc()) {
        $newStartTime = date('Y-m-d H:i:s', strtotime('+1 week', strtotime($row['start_time'])));
        $newEndTime = date('Y-m-d H:i:s', strtotime('+1 week', strtotime($row['end_time'])));

        if (strtotime($newStartTime) > strtotime($term['end_date'])) {
            continue; // Skip lessons that would fall outside the term dates
        }

        $updateSql = "UPDATE lessons SET start_time = ?, end_time = ? WHERE id = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("ssi", $newStartTime, $newEndTime, $row['id']);
        $updateStmt->execute();
        
        createNotifications($row['id'], $row['lecturer_id'], $row['class_id'], $newStartTime);
        
        $updateStmt->close();
    }

    return ['status' => 'success', 'message' => 'Lessons updated successfully.'];
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
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $response = updateLessons();
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
    <title>Update Lessons</title>
</head>
<body>
    <h1>Update Lessons</h1>
    <button id="updateLessonsBtn">Update Lessons</button>

    <script>
    document.getElementById('updateLessonsBtn').addEventListener('click', function() {
        fetch('/path/to/update_lessons.php', {
            method: 'POST'
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
