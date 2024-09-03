<?php
ob_start(); 
session_start();
require 'includes/config.php';

// Assuming the logged-in user's ID is stored in the session
$user_id = $_SESSION['user_id'];

// Update last activity time to extend session
$_SESSION['last_active_time'] = time();

// Fetch user details from the users table
$sql = "SELECT username, user_role, email, phone_number FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Fetch the current term details
$term_sql = "SELECT term_name, start_date, end_date FROM term_dates WHERE status = 'running' LIMIT 1";
$term_result = $conn->query($term_sql);
$term = $term_result->fetch_assoc();

// Fetch recipients for the message modal (excluding the logged-in user)
$recipient_sql = "SELECT id, username FROM users WHERE id != ?";
$recipient_stmt = $conn->prepare($recipient_sql);
$recipient_stmt->bind_param('i', $user_id);
$recipient_stmt->execute();
$recipients_result = $recipient_stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | NYSEI LeSA</title>
    <link rel="shortcut icon" href="dist/img/favicon.ico">
    <link rel="stylesheet" href="styles4.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
        <!-- Left Sidebar -->
        <div class="sidebar-left">
            <div class="profile-card">
                <a href="profile3.php">
                    <img src="dist/img/default_profile.png" alt="Profile Picture" class="profile-picture">
                </a>
                <h2><?php echo htmlspecialchars($user['username']); ?></h2>
                <p><?php echo htmlspecialchars($user['user_role']); ?></p>
                <p><?php echo htmlspecialchars($user['email']); ?></p>
                <p><?php echo htmlspecialchars($user['phone_number']); ?></p>
                <form method="GET" action="">
                    <button type="submit" name="dashboard"><i class="fas fa-tachometer-alt"></i> Dashboard</button>
                </form>
            </div>
            <div class="recent-section">
                <h3>Having Issues?</h3>
                <p>Contact the admin now</p>
                <ul>
                    <li><i class="fas fa-phone-alt"></i> Tel No: 0728005323</li>
                    <li><i class="fas fa-envelope"></i> Email address: <a href="mailto:mroderoben@yahoo.com">mroderoben@yahoo.com.</a></li>
                </ul>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="main-content">
            <div class="post-section" id="postSection">
                <input type="text" placeholder="Write a message to a recipient of your choice">
                <div class="post-options">
                    <button class="term-button">
                        <?php
                        if ($term) {
                            echo '<i class="fas fa-calendar-alt"></i> ' . htmlspecialchars($term['term_name']) . " (" . htmlspecialchars($term['start_date']) . " - " . htmlspecialchars($term['end_date']) . ")";
                        } else {
                            echo '<i class="fas fa-exclamation-triangle" style="color:red;"></i> No Active Term Dates Currently, contact the principal.';
                        }
                        ?>
                    </button>
                </div>
            </div>
            <div class="poll-section">
                <img src="dist/img/comb_logo.png" alt="LeSA Logo" class="logo">
                <p>
                    Welcome to the LeSA System! <br>
                    This platform enhances your educational experience with tools to update 
                    your details, manage account settings, access course information, connect 
                    with peers and lecturers, download resources, and receive real-time 
                    updates on assignments, exams, and much more.
                </p>
            </div><br>
            <div class="poll-section">
                <img src="dist/img/nys3.jpeg" alt="Get Started" class="get-started-image">
            </div>
        </div>

        <!-- Right Sidebar -->
        <div class="sidebar-right">
            <div class="upper-section-2">
                <div class="poll-section-2">
                    <h3>Your Quick Links</h3>
                    <ul>
                        <li>
                            <p>Missed Lessons</p>
                            <form action="view_missed_lessons.php" method="GET">
                                <button type="submit"><i class="fas fa-eye"></i> View</button>
                            </form>
                        </li>
                        <li>
                            <p>Absent Students</p>
                            <form action="view_absent_students.php" method="GET">
                                <button type="submit"><i class="fas fa-eye"></i> View</button>
                            </form>
                        </li>
                        <li>
                            <p>Lesson Allocations</p>
                            <form action="view_subject_allocations.php" method="GET">
                                <button type="submit"><i class="fas fa-eye"></i> View</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="lower-section">
                <div class="poll-section">
                    <h3>Copyright</h3>
                    <p>&copy; 2024 LeSA System. All rights reserved.</p>
                    <p><a href="terms.html" class="terms-link"><i class="fas fa-file-alt"></i> Terms & Conditions</a></p>
                    <p><a href="privacy.html" class="terms-link"><i class="fas fa-file-alt"></i> Privacy Policy</a></p>
                </div><br>
                <button onclick="window.location.href='logout.php';"><i class="fas fa-sign-out-alt"></i> Logout</button>
            </div>
        </div>
    </div>

    <!-- Modal for Message Form -->
<div id="messageModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2><i class="fas fa-envelope"></i> Send a Message</h2>
        <form id="messageForm" action="" method="POST">
            <label for="recipient"><i class="fas fa-user"></i> Recipient:</label>
            <select id="recipient" name="recipient" required>
                <option value="">Select Recipient</option>
                <?php while ($recipient = $recipients_result->fetch_assoc()): ?>
                    <option value="<?php echo $recipient['id']; ?>"><?php echo htmlspecialchars($recipient['username']); ?></option>
                <?php endwhile; ?>
            </select>
            <br><br>
            <label for="message"><i class="fas fa-comment-dots"></i> Message:</label>
            <textarea id="message" name="message" rows="4" cols="50" placeholder="Type your message here..." required></textarea>
            <br><br>
            <button type="submit"><i class="fas fa-paper-plane"></i> Send</button>
        </form>
        <div id="responseMessage"></div> <!-- To display success/error messages -->
    </div>
</div>
<script>

var inactiveTimeout = <?php echo 30; ?>;
    var idleTimer;

    function resetIdleTimer() {
        clearTimeout(idleTimer);
        idleTimer = setTimeout(logoutUser, inactiveTimeout * 1000);
    }

    function logoutUser() {
        window.location.href = 'auto_logout.php'; // Redirect to auto_logout page or login page
    }

    // Set up event listeners to reset idle timer on user activity
    document.addEventListener('mousemove', resetIdleTimer);
    document.addEventListener('mousedown', resetIdleTimer);
    document.addEventListener('keypress', resetIdleTimer);
    document.addEventListener('scroll', resetIdleTimer);

    // Initialize the idle timer on page load
    resetIdleTimer();



    document.getElementById('messageForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent default form submission

        // Gather form data
        var recipientId = document.getElementById('recipient').value;
        var messageContent = document.getElementById('message').value;

        // Create an AJAX request
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'send_message2.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Display the response message
                document.getElementById('responseMessage').innerHTML = xhr.responseText;
                document.getElementById('messageForm').reset(); // Reset the form
            }
        };

        // Send the request with the form data
        xhr.send('recipient=' + encodeURIComponent(recipientId) + 
                 '&message=' + encodeURIComponent(messageContent));
    });

    // Close modal logic (same as before)
    var span = document.getElementsByClassName("close")[0];
    span.onclick = function() {
        document.getElementById("messageModal").style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == document.getElementById("messageModal")) {
            document.getElementById("messageModal").style.display = "none";
        }
    }
</script>

    <script>
        // Get the modal
        var modal = document.getElementById("messageModal");

        // Get the button that opens the modal
        var postSection = document.getElementById("postSection");

        // When the user clicks the post section, open the modal 
        postSection.onclick = function() {
            modal.style.display = "block";
        }

        // Prevent the modal from opening when post options buttons are clicked
        var postOptions = document.querySelectorAll('.post-options button');
        postOptions.forEach(function(button) {
            button.onclick = function(event) {
                event.stopPropagation(); // Prevent the click from reaching the postSection
            };
        });

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>

    <?php
    // Handle the dashboard redirection based on user role
    if (isset($_GET['dashboard'])) {
        switch ($user['user_role']) {
            case 'Principal':
            case 'Deputy Principal':
                header('Location: dashboard_admin.php');
                break;
            case 'Class Representative':
                header('Location: dashboard_cRep.php');
                break;
            case 'Lecturer':
                header('Location: dashboard_lecturer.php');
                break;
            case 'HOD':
                header('Location: dashboard_hod.php');
                break;
            default:
                echo 'Invalid role';
        }
        exit();
    }
    ?>
   
</body>
</html>
<?php
ob_end_flush(); 
?>
