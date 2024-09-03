<?php
// Check if session is not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('includes/config.php');

// Redirect if user is not logged in
if (empty($_SESSION['user_id'])) {
    header('location: logout.php');
    exit; // Always exit after header redirect
}

// Update last activity time to extend session
$_SESSION['last_active_time'] = time();

// Validate and sanitize user_id from URL
$user_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($user_id <= 0) {
    echo "<script>alert('Invalid user ID.');</script>";
    echo "<script>window.location.href='manage-users.php';</script>";
    exit; // Exit if user ID is not valid
}

// Fetch user data for editing
$query = mysqli_query($conn, "SELECT * FROM users WHERE id='$user_id'");
if (!$query) {
    die("Query failed: " . mysqli_error($conn));
}

$row = mysqli_fetch_assoc($query);
if (!$row) {
    echo "<script>alert('User not found.');</script>";
    echo "<script>window.location.href='manage-users.php';</script>";
    exit; // Exit if user not found
}

// Fetch predefined roles from the `users` table
$roles_query = mysqli_query($conn, "SELECT DISTINCT user_role FROM users");
if (!$roles_query) {
    die("Roles query failed: " . mysqli_error($conn));
}

$roles = [];
while ($role_row = mysqli_fetch_assoc($roles_query)) {
    $roles[] = $role_row['user_role'];
}

// Handle form submission
if (isset($_POST['update'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']); // Sanitize input
    $email = mysqli_real_escape_string($conn, $_POST['email']); // Sanitize input
    $phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']); // Sanitize input
    $user_role = mysqli_real_escape_string($conn, $_POST['user_role']); // Sanitize input

    // Prepare statement to update user data
    $stmt = mysqli_prepare($conn, "UPDATE users SET username=?, email=?, phone_number=?, user_role=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, 'ssssi', $username, $email, $phone_number, $user_role, $user_id);
    
    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('User record updated successfully.');</script>";
        echo "<script>window.location.href='manage-users.php';</script>";
        exit; // Always exit after redirection
    } else {
        echo "<script>alert('Something went wrong. Please try again.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Edit User</title>
    <link rel="shortcut icon" href="dist/img/favicon.ico">
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="dist/css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
    <div class="hk-wrapper hk-vertical-nav">
        <?php include_once('includes/navbar.php'); ?>
        <?php include_once('includes/sidebar.php'); ?>
        <div id="hk_nav_backdrop" class="hk-nav-backdrop"></div>
        <div class="hk-pg-wrapper">
            <div class="container">
                <div class="hk-pg-header">
                    <h4 class="hk-pg-title">Edit User</h4>
                </div>
                <div class="row">
                    <div class="col-xl-12">
                        <section class="hk-sec-wrapper">
                            <div class="row">
                                <div class="col-sm">
                                    <form method="post">
                                        <div class="form-group">
                                            <label for="username">Username</label>
                                            <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($row['username']); ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="phone_number">Phone Number</label>
                                            <input type="text" class="form-control" id="phone_number" name="phone_number" value="<?php echo htmlspecialchars($row['phone_number']); ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="user_role">User Role</label>
                                            <select class="form-control" id="user_role" name="user_role" required>
                                                <?php foreach ($roles as $role) : ?>
                                                    <option value="<?php echo htmlspecialchars($role); ?>" <?php if ($row['user_role'] === $role) echo 'selected'; ?>><?php echo htmlspecialchars($role); ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary" name="update">Update</button>
                                            <a href="manage-users.php" class="btn btn-secondary">Cancel</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="vendors/jquery/dist/jquery.min.js"></script>
    <script src="vendors/popper.js/dist/umd/popper.min.js"></script>
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>
