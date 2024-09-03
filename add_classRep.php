<?php
// Check if session is not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once 'includes/config.php';
// Autoload files using Composer autoload
require 'vendor/autoload.php';

// Load PHPMailer library
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Initialize alert message variables
$alertMessage = '';
$alertType = '';

// Check if user is logged in and get department_id
if (!isset($_SESSION['user_id'])) {
    die("Please log in first.");
}

$user_id = $_SESSION['user_id'];
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the department_id of the logged-in user
$result = $conn->query("SELECT department_id FROM users WHERE id = $user_id");
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $department_id = $row['department_id'];
} else {
    die("Failed to retrieve department ID.");
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Use the correct keys for form fields
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone_number = $_POST['phone_number'] ?? '';
    $department_id = $_POST['department_id'] ?? $department_id; // Keep the fetched department_id if not provided
    $class_id = $_POST['class_id'] ?? '';

    // Check for missing values
    if (empty($name) || empty($email) || empty($phone_number) || empty($class_id)) {
        die('Please fill in all required fields.');
    }

    // Generate random password
    $password = bin2hex(random_bytes(8)); // 16 characters long
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO users (username, email, phone_number, user_role, password, department_id, class_id, otp, otp_expiry, first_login) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $user_role = 'Class Representative';
    $otp = ''; // Placeholder for OTP
    $otp_expiry = ''; // Placeholder for OTP expiry
    $first_login = 1;

    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }

    $stmt->bind_param("ssssssisss", $name, $email, $phone_number, $user_role, $hashed_password, $department_id, $class_id, $otp, $otp_expiry, $first_login);

    // Execute the statement
    if ($stmt->execute()) {
        // Send email
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com'; // Set the SMTP server to send through
            $mail->SMTPAuth   = true;
            $mail->Username   = 'benardodero21@gmail.com'; // SMTP username
            $mail->Password   = 'nfzm oxyi jstv auxp'; // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            //Recipients
            $mail->setFrom('benardodero21@gmail.com', 'NYSEI LeSA Team');
            $mail->addAddress($email);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Your Class Representative Account';
            $mail->Body    = "Hello $name,<br><br>Your account has been created successfully.<br>Here are your login credentials:<br>Email: $email<br>Password: $password<br><br>Best Regards,<br>NYSEI LeSA Admin";

            $mail->send();
            $alertMessage = 'Account created and email sent sucessfully. kindly login and change your password.';
            $alertType = 'success';
        } catch (Exception $e) {
            $alertMessage = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            $alertType = 'danger';
        }
    } else {
        echo "Error: " . htmlspecialchars($stmt->error);
    }

    $stmt->close();
}

// Fetch classes for the department_id
$classes_result = $conn->query("SELECT id, class_name FROM classes WHERE department_id = $department_id");
if ($classes_result === false) {
    die('Query failed: ' . htmlspecialchars($conn->error));
}

$classes = [];
while ($row = $classes_result->fetch_assoc()) {
    $classes[] = $row;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Class Rep</title>
    <link rel="shortcut icon" href="dist/img/favicon.ico">
    <link href="vendors/jquery-toggles/css/toggles.css" rel="stylesheet" type="text/css">
    <link href="vendors/jquery-toggles/css/themes/toggles-light.css" rel="stylesheet" type="text/css">
    <link href="dist/css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
    <!-- HK Wrapper -->
<div class="hk-wrapper hk-vertical-nav">

<!-- Top Navbar -->
<?php include_once('includes/navbar.php'); ?>
<?php include_once('includes/sidebar.php'); ?>
<div id="hk_nav_backdrop" class="hk-nav-backdrop"></div>
<!-- /Vertical Nav -->

<!-- Main Content -->
<div class="hk-pg-wrapper">
    <!-- Breadcrumb -->
    <nav class="hk-breadcrumb" aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-light bg-transparent">
            <li class="breadcrumb-item"><a href="dashboard_hod.php">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add Class Representative</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container">
        <!-- Title -->
        <div class="hk-pg-header">
            <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="external-link"></i></span></span>Add Class Representative</h4>
        </div>
        <!-- /Title -->

        <!-- Alert Messages -->
        <?php if ($alertMessage != ''): ?>
            <div class="alert alert-<?php echo $alertType; ?> alert-dismissible fade show" role="alert">
                <?php echo $alertMessage; ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>
        <!-- /Alert Messages -->

        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row">
                        <div class="col-sm">
                            <form method="POST" action="">
                                <h4>Enter Class Representative Details</h4>
                                <div class="form-row">
                                    <div class="col-md-6 mb-10">
                                        <label for="validationCustom03">Name</label>
                                        <input type="text" class="form-control" id="validationCustom03" placeholder="Enter the class Representative name" name="name" required>
                                        <div class="invalid-feedback">Please provide a valid name.</div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6 mb-10">
                                        <label for="validationCustom03">Email Address</label>
                                        <input type="email" class="form-control" id="validationCustom03" placeholder="Enter email address" name="email" required>
                                        <div class="invalid-feedback">Enter a valid email address</div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6 mb-10">
                                        <label for="validationCustom03">Phone Number</label>
                                        <input type="text" class="form-control" id="validationCustom03" placeholder="Enter phone number" name="phone_number" required>
                                        <div class="invalid-feedback">Enter a valid phone number</div>
                                    </div>
                                </div>
                                <!-- Hidden field to store department_id -->
                                <input type="hidden" id="department_id" name="department_id" value="<?php echo htmlspecialchars($department_id); ?>">
                                <div class="form-row">
                                    <div class="col-md-6 mb-10">
                                        <label for="validationCustom03">Class Name</label>
                                        <select class="form-control" id="validationCustom03" name="class_id" required>
                                            <option value="">Select a class</option>
                                            <?php
                                            foreach ($classes as $class) {
                                                echo '<option value="' . htmlspecialchars($class['id']) . '">' . htmlspecialchars($class['class_name']) . '</option>';
                                            }
                                            ?>
                                        </select>
                                        <div class="invalid-feedback">Please select the class name.</div>
                                    </div>
                                </div>
                                <button class="btn btn-primary" type="submit" name="add_class">Create Account</button>
                            </form>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <!-- /Container -->
</div>
<!-- /Main Content -->
</div>

<script src="vendors/jquery/dist/jquery.min.js"></script>
<script src="vendors/popper.js/dist/umd/popper.min.js"></script>
<script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="vendors/jasny-bootstrap/dist/js/jasny-bootstrap.min.js"></script>
<script src="dist/js/jquery.slimscroll.js"></script>
<script src="dist/js/dropdown-bootstrap-extended.js"></script>
<script src="dist/js/feather.min.js"></script>
<script src="vendors/jquery-toggles/toggles.min.js"></script>
<script src="dist/js/toggle-data.js"></script>
<script src="dist/js/init.js"></script>
<script src="dist/js/validation-data.js"></script>

<script>
    var inactiveTimeout = <?php echo 300; ?>;
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
</script>

</body>
</html>

<?php
// Close database connection
$conn->close();
?>
