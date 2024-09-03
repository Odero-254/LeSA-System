<?php
// Check if session is not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Include database connection
require_once 'includes/config.php';

// Initialize variables
$message = '';

// Check if 'id' is set in the URL
if (isset($_GET['id'])) {
    $encoded_id = $_GET['id'];
    $decoded_id = base64_decode(urldecode($encoded_id));
    
    // Fetch user details
    if ($stmt = $conn->prepare("SELECT id, username, email, phone_number, user_role, department_id FROM users WHERE id = ?")) {
        $stmt->bind_param("i", $decoded_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();
    } else {
        $message = "Error fetching user details.";
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input data
    $id = $_POST['id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $user_role = $_POST['user_role'];
    $department_id = $_POST['department_id'];
    
    // Update user details
    if ($stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, phone_number = ?, user_role = ?, department_id = ? WHERE id = ?")) {
        $stmt->bind_param("ssssii", $username, $email, $phone_number, $user_role, $department_id, $id);
        if ($stmt->execute()) {
            $message = "User details updated successfully.";
        } else {
            $message = "Error updating user details.";
        }
        $stmt->close();
    } else {
        $message = "Error preparing update statement.";
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <link rel="stylesheet" href="includes/style.css">
</head>
<body>

<div class="container">
    <h1>Edit User</h1>

    <?php if (!empty($message)): ?>
        <div class="alert">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($user)): ?>
        <form action="edit_user.php" method="POST">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($user['id']); ?>">

            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>

            <div class="form-group">
                <label for="phone_number">Phone Number:</label>
                <input type="text" id="phone_number" name="phone_number" value="<?php echo htmlspecialchars($user['phone_number']); ?>" required>
            </div>

            <div class="form-group">
                <label for="user_role">User Role:</label>
                <input type="text" id="user_role" name="user_role" value="<?php echo htmlspecialchars($user['user_role']); ?>" required>
            </div>

            <div class="form-group">
                <label for="department_id">Department ID:</label>
                <input type="number" id="department_id" name="department_id" value="<?php echo htmlspecialchars($user['department_id']); ?>" required>
            </div>

            <button type="submit">Update User</button>
        </form>
    <?php else: ?>
        <p>User not found.</p>
    <?php endif; ?>

</div>

</body>
</html>
