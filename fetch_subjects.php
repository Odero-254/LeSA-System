<?php
require_once 'includes/config.php';

if (isset($_POST['lecturer_id'])) {
    $lecturer_id = $_POST['lecturer_id'];

    // Fetch subjects for the selected lecturer
    $query = "SELECT subjects.id, subjects.subject_name 
              FROM lecturer_subjects 
              JOIN subjects ON lecturer_subjects.subject_id = subjects.id 
              WHERE lecturer_subjects.lecturer_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $lecturer_id);
    $stmt->execute();
    $result = $stmt->get_result();

    echo '<option value="">Select Subject</option>';
    while ($row = $result->fetch_assoc()) {
        echo '<option value="' . $row['id'] . '">' . $row['subject_name'] . '</option>';
    }
    $stmt->close();
}
?>
