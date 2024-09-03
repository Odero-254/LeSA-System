<?php
require 'includes/config.php';

// Get current date minus 10 days
$date_threshold = date('Y-m-d H:i:s', strtotime('-10 days'));

// Update status to 'Rejected' for old pending requests
$sql = "UPDATE account_requests SET status = 'Rejected' WHERE status = 'Pending' AND created_at < ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $date_threshold);

if ($stmt->execute()) {
    echo "Old pending requests have been rejected.";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
