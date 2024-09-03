<?php
// Check if session is not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require 'includes/config.php';

$role = $_SESSION['role'];

if ($role !== 'Principal' && $role !== 'Deputy Principal') {
    echo "Access denied.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id'])) {
    $request_id = $_POST['id'];

    // Check if an account already exists
    $sql_check_account = "SELECT id FROM users WHERE account_request_id = ?";
    $stmt_check_account = $conn->prepare($sql_check_account);
    $stmt_check_account->bind_param("i", $request_id);
    $stmt_check_account->execute();
    $stmt_check_account->store_result();

    if ($stmt_check_account->num_rows > 0) {
        $stmt_check_account->close();
        echo "Account already exists for this request."; // Account already exists
    } else {
        $stmt_check_account->close();

        // Proceed to approve the request
        $sql_approve = "UPDATE account_requests SET status = 'Approved' WHERE id = ?";
        $stmt_approve = $conn->prepare($sql_approve);
        $stmt_approve->bind_param("i", $request_id);

        if ($stmt_approve->execute()) {
            $stmt_approve->close();
            echo "Request approved successfully."; // Success message
        } else {
            echo "Error approving request: " . $conn->error; // Error message
        }
    }
} else {
    echo "Invalid request."; // Invalid request
}
?>
