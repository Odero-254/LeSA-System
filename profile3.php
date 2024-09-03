<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include 'header.php';

// Include the database connection
include('includes/config.php');


// Update last activity time to extend session
$_SESSION['last_active_time'] = time();

// having stored the user's ID in the session
$user_id = $_SESSION['user_id'];

// Fetch user details from the database
$sql = "SELECT u.id, u.username, u.email, u.phone_number, u.user_role, u.UpdationDate, d.name AS department_name
        FROM users u
        JOIN department d ON u.department_id = d.id
        WHERE u.id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Fetch data into an associative array
    $user = $result->fetch_assoc();
} else {
    echo "No records found!";
    exit();
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <link rel="shortcut icon" href="dist/img/favicon.ico">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="style3.css">
    <style>
        .button-container {
            margin-top: 10px;
        }

        .edit-button, .back-button {
            display: inline-block;
            margin-top: 10px;
            padding: 10px 20px;
            font-size: 14px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 50px;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
        }

        .edit-button i, .back-button i {
            margin-right: 8px;
        }

        .edit-button {
            background-color: #007bff;
        }

        .edit-button:hover {
            background-color: #0056b3;
        }

        .back-button {
            background-color: #6c757d;
        }

        .back-button:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
    <div class="profile">
        <div class="profile-pic">
            <img src="dist/img/default_profile.png" alt="Profile Picture"><br>
            <div class="button-container">
                <a href="settings.php" class="edit-button">
                    <i class="fas fa-edit"></i>Profile
                </a><br>
                <a href="javascript:history.back()" class="back-button">
                    <i class="fas fa-arrow-left"></i>Back
                </a>
            </div>
        </div>
        <div class="profile-details">
            <div class="detail-row">
                <span class="detail-title">User ID</span>
                <span class="detail-info"><?php echo $user['id']; ?></span>
            </div>
            <hr>
            <div class="detail-row">
                <span class="detail-title">Full Name</span>
                <span class="detail-info"><?php echo $user['username']; ?></span>
            </div>
            <hr>
            <div class="detail-row">
                <span class="detail-title">Email Address</span>
                <span class="detail-info"><?php echo $user['email']; ?></span>
            </div>
            <hr>
            <div class="detail-row">
                <span class="detail-title">Phone Number</span>
                <span class="detail-info"><?php echo $user['phone_number']; ?></span>
            </div>
            <hr>
            <div class="detail-row">
                <span class="detail-title">Your Role</span>
                <span class="detail-info"><?php echo $user['user_role']; ?></span>
            </div>
            <hr>
            <div class="detail-row">
                <span class="detail-title">Last Date Updated</span>
                <span class="detail-info"><?php echo $user['UpdationDate']; ?></span>
            </div>
            <hr>
            <div class="detail-row">
                <span class="detail-title">Department Name</span>
                <span class="detail-info"><?php echo $user['department_name']; ?></span>
            </div>
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
