<?php
// Check if session is not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    die('Error: User not logged in.');
}

$loggedInUserId = $_SESSION['user_id'];

// Database connection (replace with your connection details)
$conn = mysqli_connect('localhost', 'root', '', 'nysei_lesa');
if (!$conn) {
    die('Error: Unable to connect to database. ' . mysqli_connect_error());
}

// Function to display messages with CRUD operations
function displayMessages($query, $status) {
    global $conn;
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die('Error: ' . mysqli_error($conn)); // Query failed
    }

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $messageId = isset($row['id']) ? htmlspecialchars($row['id']) : '';
            $senderName = isset($row['sender_name']) ? htmlspecialchars($row['sender_name']) : '';
            $messageContent = isset($row['message']) ? nl2br(htmlspecialchars($row['message'])) : ''; // Convert newlines to <br> for proper display
            $file = isset($row['file']) ? htmlspecialchars($row['file']) : '';

            echo "<div class='card mb-3'>";
            echo "<div class='card-header'><strong>Message from {$senderName}:</strong></div>";
            echo "<div class='card-body'>";
            echo "<p><strong>Message:</strong><br>" . substr($messageContent, 0, 100) . "...</p>"; // Display first 100 characters
            
            if (!empty($file)) {
                echo "<p><strong>Attachment:</strong><br>";
                echo "<a href='uploads/{$file}' target='_blank' class='btn btn-primary btn-sm'>View</a> ";
                echo "<a href='uploads/{$file}' download class='btn btn-secondary btn-sm'>Download</a> ";
                echo "<button class='btn btn-info btn-sm' onclick=\"window.open('uploads/{$file}', '_blank').print()\">Print</button>";
                echo "</p>";
            }

            echo "<form method='post' action=''>";
            echo "<input type='hidden' name='message_id' value='{$messageId}'>";
            echo "<button type='button' class='btn btn-info btn-sm' onclick='viewMessage(\"{$messageContent}\")'>View</button> ";
            echo "<button type='submit' name='action' value='delete' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this message?\")'>Delete</button>";
            echo "</form>";
            echo "</div>";
            echo "</div>";
        }
    } else {
        echo "<div class='alert alert-info'>No {$status} messages.</div>";
    }
}

// Handle CRUD operations
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    $messageId = isset($_POST['message_id']) ? (int)$_POST['message_id'] : 0;

    if ($action == 'delete' && $messageId > 0) {
        $deleteQuery = "DELETE FROM messages WHERE id = {$messageId}";
        if (mysqli_query($conn, $deleteQuery)) {
            echo "<div class='alert alert-success'>Message deleted successfully.</div>";
        } else {
            echo "<div class='alert alert-danger'>Error deleting message: " . mysqli_error($conn) . "</div>";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Manage Messages</title>
    <link rel="shortcut icon" href="dist/img/favicon.ico">
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="dist/css/style.css" rel="stylesheet">
</head>

<body>
    <!-- HK Wrapper -->
    <div class="hk-wrapper hk-vertical-nav">

        <!-- Top Navbar -->
        <?php include_once('includes/navbar.php'); ?>
        <!-- /Top Navbar -->

        <!-- Sidebar -->
        <?php include_once('includes/sidebar.php'); ?>
        <!-- /Sidebar -->

        <div id="hk_nav_backdrop" class="hk-nav-backdrop"></div>

        <!-- Main Content -->
        <div class="hk-pg-wrapper">
            <!-- Breadcrumb -->
            <nav class="hk-breadcrumb" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-light bg-transparent">
                    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Manage Messages</li>
                </ol>
            </nav>
            <!-- /Breadcrumb -->

            <!-- Container -->
            <div class="container">
                <!-- Title -->
                <div class="hk-pg-header">
                    <h4 class="hk-pg-title">
                        <span class="pg-title-icon">
                            <span class="feather-icon">
                                <i data-feather="message-square"></i>
                            </span>
                        </span>
                        Manage Messages
                    </h4>
                </div>
                <!-- /Title -->

                <div class="row">
                    <div class="col-xl-12">
                        <section class="hk-sec-wrapper">
                            <div class="container mt-4">
                                <!-- Your message management code starts here -->
                                <?php
                                // Example usage of displayMessages function
                                $query = "SELECT m.id, u.username AS sender_name, m.message, m.file
                                          FROM messages m
                                          JOIN users u ON m.sender_id = u.id
                                          WHERE m.status = 'unread'";
                                displayMessages($query, 'unread');
                                ?>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
            <!-- /Container -->
        </div>
        <!-- /Main Content -->

    </div>
    <!-- /HK Wrapper -->

    <!-- Scripts -->
    <script src="vendors/jquery/dist/jquery.min.js"></script>
    <script src="vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="dist/js/feather.min.js"></script>
    <script src="dist/js/init.js"></script>
</body>

</html>
