<?php
require 'includes/config.php';

if (isset($_GET['request_id']) && isset($_GET['status']) && $_GET['status'] == 'rejected') {
    $request_id = $_GET['request_id'];

    // Update the status of the account request to rejected
    $sql = "UPDATE account_requests SET status = 'Rejected' WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }

    $stmt->bind_param("i", $request_id);

    if (!$stmt->execute()) {
        die('Execute failed: ' . htmlspecialchars($stmt->error));
    }

    $stmt->close();

    // Redirect back to a relevant page after rejecting the request
    header("Location: dashboard.php"); // Adjust the location as needed
    exit();
} else {
    die('Invalid request.');
}
?>
