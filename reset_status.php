<?php
require 'includes/config.php'; 

// SQL query to reset the status to 'pending'
$sql = "UPDATE allocations SET status = 'pending' WHERE status IN ('taught', 'missed')";

// Execute the query
if ($conn->query($sql) === TRUE) {
    echo "Statuses reset to pending successfully.";
} else {
    echo "Error updating statuses: " . $conn->error;
}

$conn->close();
?>
