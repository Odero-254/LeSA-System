<?php
require_once 'includes/config.php';

$departments = [];
$result = $conn->query("SELECT id, name FROM department");
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $departments[] = $row;
    }
}

echo json_encode($departments);
?>
