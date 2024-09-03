<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('includes/config.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$query = mysqli_query($conn, "SELECT u.username, u.user_role, c.class_name, d.name AS department
                              FROM users u
                              LEFT JOIN classes c ON u.class_id = c.id
                              LEFT JOIN department d ON u.department_id = d.id
                              WHERE u.id='$user_id'");
if ($row = mysqli_fetch_array($query)) {
    $user_role = $row['user_role'];

    // Fetch unread notification count
    $unread_count_query = mysqli_query($conn, "SELECT COUNT(*) AS unread_count FROM notifications WHERE user_role='$user_role' AND status='unread'");
    $unread_count_row = mysqli_fetch_array($unread_count_query);
    $unread_count = $unread_count_row['unread_count'];

    // Adjust display for notification count
    if ($unread_count > 9) {
        $unread_count_display = '9+';
    } else {
        $unread_count_display = $unread_count;
    }

    $role_info = "";
    switch ($user_role) {
        case 'Class Representative':
            $role_info = $user_role . " of " . htmlspecialchars($row['class_name']);
            break;
        case 'Lecturer':
            $role_info = $user_role . " in the " . htmlspecialchars($row['department']) . " department";
            break;
        case 'HOD':
            $role_info = $user_role . " of " . htmlspecialchars($row['department']) . " department";
            break;
        case 'Principal':
        case 'Deputy Principal':
            $role_info = $user_role . " of NYS Engineering Institute";
            break;
    }
}
?>

<nav class="navbar navbar-expand-xl navbar-light fixed-top hk-navbar">
    <a id="navbar_toggle_btn" class="navbar-toggle-btn nav-link-hover" href="javascript:void(0);"><i class="ion ion-ios-menu"></i></a>
    <a class="navbar-brand" href="home.php">
        <img src="dist/img/comb_logo.png" alt="Logo" class="navbar-logo">
    </a>

    <?php if(isset($user_role)): ?>
    <ul class="navbar-nav hk-navbar-content">
        <li class="nav-item">
            <div class="media">
                <div class="media-body">
                    <span><?php echo htmlspecialchars($role_info); ?></span>
                </div>
            </div>
        </li>
    </ul>
    <?php endif; ?>
    
    <ul class="navbar-nav hk-navbar-content">
        <li class="nav-item dropdown">
            <a class="nav-link" href="#" id="notificationDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="ion ion-ios-notifications-outline"></i>
                <?php if ($unread_count > 0) { ?>
                    <span class="badge badge-danger"><?php echo $unread_count_display; ?></span>
                <?php } ?>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="notificationDropdown">
                <h6 class="dropdown-header">Notifications</h6>
                <?php if ($unread_count > 0): ?>
                    <p class="dropdown-item">You have <?php echo $unread_count; ?> new notifications</p>
                <?php else: ?>
                    <p class="dropdown-item">You do not have new notifications</p>
                <?php endif; ?>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item text-center" href="notifications.php">See all</a>
            </div>
        </li>
        <li class="nav-item dropdown dropdown-authentication">
            <a class="nav-link dropdown-toggle no-caret" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <div class="media">
                    <div class="media-img-wrap">
                        <div class="avatar">
                            <img src="dist/img/default_profile.png" alt="user" class="avatar-img rounded-circle">
                        </div>
                    </div>
                    <div class="media-body">
                        <?php if(isset($row['username'])) { ?>
                        <span><?php echo htmlspecialchars($row['username']); ?> <i class="zmdi zmdi-chevron-down"></i> </span>
                        <?php } ?>
                    </div>
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-right" data-dropdown-in="flipInX" data-dropdown-out="flipOutX">
                <a class="dropdown-item" href="profile3.php"><i class="dropdown-icon zmdi zmdi-account"></i><span>Profile</span></a>
                <a class="dropdown-item" href="settings.php"><i class="dropdown-icon zmdi zmdi-settings"></i><span>Settings</span></a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="logout.php"><i class="dropdown-icon zmdi zmdi-power"></i><span>Log out</span></a>
            </div>
        </li>
    </ul>
</nav>

<style>
    .navbar-logo {
        height: 40px; /* Adjust the size as needed */
        width: auto;
    }
    
    .badge-danger {
        background-color: red;
        color: white;
        font-size: 12px;
        border-radius: 50%;
        padding: 4px 7px;
        position: absolute;
        top: 5px;
        right: 10px;
    }
</style>
