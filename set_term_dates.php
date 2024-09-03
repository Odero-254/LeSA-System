<?php
// Check if session is not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require 'includes/config.php';

// Assuming the logged-in user's ID is stored in a session variable
$loggedInUserId = $_SESSION['user_id'] ?? null;

$showReasonField = false;
$term_dates = []; // Initialize $term_dates

// Update term statuses based on the current date
$currentDate = date('Y-m-d');
$update_status_sql = "UPDATE term_dates SET status = 'completed' WHERE end_date < ? AND status = 'running'";
$stmt = $conn->prepare($update_status_sql);
$stmt->bind_param("s", $currentDate);
$stmt->execute();
$stmt->close();

// Handle setting term dates
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['set_term_dates'])) {
    $term_name = $_POST['term_name'] ?? '';
    $start_date = $_POST['start_date'] ?? '';
    $end_date = $_POST['end_date'] ?? '';

    // Validate input
    if (empty($term_name) || empty($start_date) || empty($end_date)) {
        $_SESSION['alertMessage'] = 'All fields are required.';
        $_SESSION['alertType'] = 'danger';
        header('Location: set_term_dates.php');
        exit();
    }

    // Check for an existing running term
    $query = "SELECT COUNT(*) AS count FROM term_dates WHERE status = 'running'";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();
    if ($row['count'] > 0) {
        $_SESSION['alertMessage'] = 'There is already an active term. Please end the current term before setting a new one.';
        $_SESSION['alertType'] = 'danger';
        header('Location: set_term_dates.php');
        exit();
    }

    // Insert term dates into the database
    $sql = "INSERT INTO term_dates (term_name, start_date, end_date, status) VALUES (?, ?, ?, 'running')";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        $_SESSION['alertMessage'] = 'Prepare failed: ' . htmlspecialchars($conn->error);
        $_SESSION['alertType'] = 'danger';
        header('Location: set_term_dates.php');
        exit();
    }

    $stmt->bind_param("sss", $term_name, $start_date, $end_date);

    if (!$stmt->execute()) {
        $_SESSION['alertMessage'] = 'Execute failed: ' . htmlspecialchars($stmt->error);
        $_SESSION['alertType'] = 'danger';
        header('Location: set_term_dates.php');
        exit();
    }

    $stmt->close();

    // Notify the user of the successful action
    $_SESSION['alertMessage'] = 'Term dates have been set successfully.';
    $_SESSION['alertType'] = 'success';
    header('Location: set_term_dates.php');
    exit();
}

// Handle ending the term prematurely
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['end_term'])) {
    if (isset($_POST['reason'])) {
        $reason = $_POST['reason'] ?? '';

        // Validate input
        if (empty($reason)) {
            $_SESSION['alertMessage'] = 'Reason is required.';
            $_SESSION['alertType'] = 'danger';
            header('Location: set_term_dates.php');
            exit();
        }

        // Update the current term status to 'stopped'
        $sql = "UPDATE term_dates SET status = 'stopped' WHERE status = 'running'";
        $conn->query($sql);

        // Insert notifications for all users except the logged-in user
        $notification_sql = "INSERT INTO notifications (user_id, message, notification_time, status) 
                             SELECT id, ?, NOW(), 'unread' 
                             FROM users 
                             WHERE id != ?";
        $stmt = $conn->prepare($notification_sql);
        $message = "Premature end of term: " . $reason;

        if ($stmt === false) {
            $_SESSION['alertMessage'] = 'Prepare failed: ' . htmlspecialchars($conn->error);
            $_SESSION['alertType'] = 'danger';
            header('Location: set_term_dates.php');
            exit();
        }

        $stmt->bind_param("si", $message, $loggedInUserId);

        if (!$stmt->execute()) {
            $_SESSION['alertMessage'] = 'Execute failed: ' . htmlspecialchars($stmt->error);
            $_SESSION['alertType'] = 'danger';
            header('Location: set_term_dates.php');
            exit();
        }

        $stmt->close();

        // Notify the user of the successful action
        $_SESSION['alertMessage'] = 'The term has been ended prematurely. Reason: ' . htmlspecialchars($reason);
        $_SESSION['alertType'] = 'success';
        header('Location: set_term_dates.php');
        exit();
    } else {
        $showReasonField = true;
    }
}

// Fetch existing term dates for display
$query = "SELECT * FROM term_dates ORDER BY start_date DESC";
$result = $conn->query($query);
$term_dates = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Set Term Dates</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .end-term-button {
            font-weight: bold;
            color: white;
            background-color: red;
            padding: 10px;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <!-- Display notifications -->
    <?php if (isset($_SESSION['alertMessage'])): ?>
        <div class="alert alert-<?= htmlspecialchars($_SESSION['alertType']) ?>">
            <?= htmlspecialchars($_SESSION['alertMessage']) ?>
        </div>
        <?php unset($_SESSION['alertMessage'], $_SESSION['alertType']); ?>
    <?php endif; ?>

    <h1>Set Term Dates</h1>
    <form method="POST" action="set_term_dates.php">
        <input type="hidden" name="set_term_dates" value="1">
        <div>
            <label for="term_name">Term Name:</label>
            <input type="text" name="term_name" id="term_name" required>
        </div>
        <div>
            <label for="start_date">Start Date:</label>
            <input type="date" name="start_date" id="start_date" required>
        </div>
        <div>
            <label for="end_date">End Date:</label>
            <input type="date" name="end_date" id="end_date" required>
        </div>
        <button type="submit">Set Term Dates</button>
    </form>

    <h2>End Current Term</h2>
    <form method="POST" action="set_term_dates.php">
        <input type="hidden" name="end_term" value="1">
        <?php if ($showReasonField): ?>
            <div>
                <label for="reason">Reason for Ending Term:</label>
                <textarea name="reason" id="reason" required></textarea>
            </div>
        <?php endif; ?>
        <button type="submit" class="end-term-button">End Current Term</button>
    </form>

    <!-- Display existing term dates -->
    <h2>Existing Term Dates</h2>
    <table>
        <tr>
            <th>Term Name</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Status</th>
        </tr>
        <?php foreach ($term_dates as $term) : ?>
            <tr>
                <td><?= htmlspecialchars($term['term_name']) ?></td>
                <td><?= htmlspecialchars($term['start_date']) ?></td>
                <td><?= htmlspecialchars($term['end_date']) ?></td>
                <td><?= htmlspecialchars($term['status']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
