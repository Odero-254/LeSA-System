<?php
// Check if session is not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include the database configuration file
include('includes/config.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "No user is logged in.";
    exit();
}
// Update last activity time to extend session
$_SESSION['last_active_time'] = time();

// Fetch user data from session
$user_id = $_SESSION['user_id'];

// Construct SQL query
$sql = "SELECT u.username, u.email, u.phone_number, u.user_role, 
        d.name AS department_name, c.class_name 
        FROM users u
        JOIN department d ON u.department_id = d.id
        JOIN classes c ON u.class_id = c.id
        WHERE u.id = $user_id";

// Execute the query
$result = $conn->query($sql);

// Check for results
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "No user found. SQL query: " . $sql;
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profile</title>
    <link rel="shortcut icon" href="dist/img/favicon.ico">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }
        .profile-container {
            width: 50%;
            margin: 50px auto;
            border: 1px solid #e0e0e0;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }
        .profile-container h1 {
            text-align: center;
            color: #333;
        }
        .profile-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
        }
        .profile-row div {
            width: 45%;
        }
        .profile-row div span {
            font-weight: bold;
            color: #333;
        }
        .profile-pic {
            text-align: center;
            margin-bottom: 20px;
        }
        .profile-pic img {
            border-radius: 50%;
            width: 100px;
            height: 100px;
        }
    </style>
</head>
<body>
<div class="profile-container">
    <h1>Profile</h1>
    <div class="profile-pic">
        <img src="dist/img/default_profile.png" alt="Profile Picture">
    </div>
    <div class="profile-row">
        <div><span>Full Name:</span> <?php echo $user['username']; ?></div>
    </div>
    <div class="profile-row">
        <div><span>Phone Number:</span> <?php echo $user['phone_number']; ?></div>
    </div>
    <div class="profile-row">
        <div><span>Email Address:</span> <?php echo $user['email']; ?></div>
    </div>
    <div class="profile-row">
        <div><span>Department:</span> <?php echo $user['department_name']; ?></div>
        <div><span>Class:</span> <?php echo $user['class_name']; ?></div>
    </div>
    <div class="profile-row">
        <div><span>User Role:</span> <?php echo $user['user_role']; ?></div>
    </div>
</div>
<script>
    var inactiveTimeout = <?php echo 300; ?>; 
    var idleTimer;

    function resetIdleTimer() {
        clearTimeout(idleTimer);
        idleTimer = setTimeout(logoutUser, inactiveTimeout * 1000);
    }

    function logoutUser() {
        window.location.href = 'auto_logout.php'; 

    // Set up event listeners to reset idle timer on user activity
    document.addEventListener('mousemove', resetIdleTimer);
    document.addEventListener('mousedown', resetIdleTimer);
    document.addEventListener('keypress', resetIdleTimer);
    document.addEventListener('scroll', resetIdleTimer);
    }
    // Initialize the idle timer on page load
    resetIdleTimer();
    </script>
</body>
</html>
