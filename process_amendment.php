<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "LeSA_system";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$lecturer_id = $_POST['lecturer_id'];
$subject_id = $_POST['subject_id'];

// Check for conflicts
$conflict_check = $conn->query("SELECT * FROM allocations WHERE lecturer_id = $lecturer_id AND subject_id = $subject_id");

if ($conflict_check->num_rows == 0) {
    // Assign subject to lecturer
    $conn->query("INSERT INTO allocations (lecturer_id, subject_id) VALUES ($lecturer_id, $subject_id)");
    echo "Subject allocated successfully.";
} else {
    echo "Conflict detected. This allocation already exists.";
}

$conn->close();
