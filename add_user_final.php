<?php
// Check if session is not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once 'includes/config.php';
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Initialize alert message variables
$alertMessage = '';
$alertType = '';

if (!isset($_SESSION['form1']) || !isset($_SESSION['form2']) || !isset($_SESSION['form3'])) {
    $_SESSION['error'] = 'Missing form data.';
    header("Location: add_user.php");
    exit();
}

$form1 = $_SESSION['form1'];
$form2 = $_SESSION['form2'];
$form3 = $_SESSION['form3'];

// Extract subject IDs, names, and qualifications from the form data
$subject_ids = isset($form3['subject_ids']) ? explode(',', $form3['subject_ids']) : [];
$qualifications = isset($form3['qualifications']) ? explode(',', $form3['qualifications']) : [];

// Generate random password
function generateRandomPassword($length = 8) {
    return substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, $length);
}

$password = generateRandomPassword();
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
$UserRegDate = date('Y-m-d H:i:s');
$otp = rand(100000, 999999);
$otp_expiry = date('Y-m-d H:i:s', strtotime('+15 minutes'));
$first_login = 1;

// Initialize the database transaction
$conn->autocommit(FALSE);

try {
    // Check for duplicates
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ? OR phone_number = ?");
    $stmt->bind_param("sss", $form1['username'], $form1['email'], $form1['phone_number']);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $_SESSION['error'] = "Username, Email, or Phone Number already exists.";
        header("Location: add_user.php");
        exit();
    }

    // Insert into users table
    $stmt = $conn->prepare("INSERT INTO users (username, email, phone_number, user_role, password, department_id, class_id, otp, otp_expiry, first_login) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssisis", $form1['username'], $form1['email'], $form1['phone_number'], $form2['user_role'], $hashed_password, $form2['department_id'], $form2['class_id'], $otp, $otp_expiry, $first_login);
    if ($stmt->execute() === TRUE) {
        $user_id = $stmt->insert_id;

        // Insert into HOD or lecturers table
        if ($form2['user_role'] === 'HOD') {
            // Insert into HOD table
            $stmt = $conn->prepare("INSERT INTO hod (username, qualifications, user_id, department_id) VALUES (?, ?, ?, ?)");
            $qualification_list = implode(',', $qualifications);
            $stmt->bind_param("ssii", $form1['username'], $qualification_list, $user_id, $form2['department_id']);
            $stmt->execute();

            // Insert into hod_subjects table
            foreach ($subject_ids as $subject_id) {
                $stmt = $conn->prepare("INSERT INTO hod_subjects (hod_id, subject_id) VALUES (?, ?)");
                $stmt->bind_param("ii", $user_id, $subject_id);
                $stmt->execute();
            }
        } elseif ($form2['user_role'] === 'Lecturer') {
            // Insert into lecturers table
            $stmt = $conn->prepare("INSERT INTO lecturers (username, user_id, department_id) VALUES (?, ?, ?)");
            $stmt->bind_param("sii", $form1['username'], $user_id, $form2['department_id']);
            $stmt->execute();

            // Check if lecturer was successfully inserted
            if ($stmt->affected_rows > 0) {
                $lecturer_id = $stmt->insert_id; // Get the inserted lecturer ID

                // Insert into lecturer_qualifications table
                foreach ($qualifications as $qualification) {
                    $stmt = $conn->prepare("INSERT INTO lecturer_qualifications (lecturer_id, qualification) VALUES (?, ?)");
                    $stmt->bind_param("is", $lecturer_id, $qualification);
                    if (!$stmt->execute()) {
                        throw new Exception("Failed to insert into lecturer_qualifications table.");
                    }
                }

                // Insert into lecturer_subjects table
                foreach ($subject_ids as $subject_id) {
                    $stmt = $conn->prepare("INSERT INTO lecturer_subjects (lecturer_id, subject_id) VALUES (?, ?)");
                    $stmt->bind_param("ii", $lecturer_id, $subject_id);
                    if (!$stmt->execute()) {
                        throw new Exception("Failed to insert into lecturer_subjects table.");
                    }
                }
            } else {
                throw new Exception("Failed to insert into lecturers table.");
            }
        }

        // Commit transaction
        $conn->commit();

        // Send email with PHPMailer
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'benardodero21@gmail.com';
            $mail->Password = 'nfzm oxyi jstv auxp';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('benardodero21@gmail.com', 'NYSEI LeSA Team');
            $mail->addAddress($form1['email']);

            $mail->isHTML(true);
            $mail->Subject = 'Welcome to NYSEI LeSA System';
            $mail->Body = "Dear {$form1['username']},<br><br>Your account has been created successfully.<br>Your login details are:<br>Email: {$form1['email']}<br>Password: $password<br><br>Best regards,<br>NYSEI LeSA Admin";

            if ($mail->send()) {
                $alertMessage = "Account created and email sent successfully. Kindly login and change your password.";
                $alertType = "success";
            } else {
                $alertMessage = "Account created successfully but email could not be sent.";
                $alertType = "warning";
            }
        } catch (Exception $e) {
            $alertMessage = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            $alertType = "danger";
        }

    } else {
        throw new Exception("User insertion failed.");
    }
} catch (Exception $e) {
    $conn->rollback();
    $alertMessage = "Failed to add user: " . $e->getMessage();
    $alertType = "danger";
} finally {
    $conn->autocommit(TRUE);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add User - autocommit</title>
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
            <li class="breadcrumb-item"><a href="dashboard_admin.php">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add User / Role and Department </li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container">
        <!-- Title -->
        <div class="hk-pg-header">
            <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="external-link"></i></span></span>Add User</h4>
        </div>
        <!-- /Title -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row">
                        <div class="col-sm">
                            <!-- Page Content -->
                            <div class="content">
                                <?php if ($alertMessage): ?>
                                    <div class="alert alert-<?php echo htmlspecialchars($alertType); ?> alert-dismissible fade show" role="alert">
                                        <?php echo htmlspecialchars($alertMessage); ?>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                <?php endif; ?>
                                <!-- End Alert -->
                                <div class="container">
                                    <form action="add_user.php" method="POST">
                                    <button class="btn btn-primary" type="submit" name="add user">Go Back</button>
                                    </form>
                                </div>
                            </div>
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
<!-- /HK Wrapper -->

<script src="vendors/jquery/dist/jquery.min.js"></script>
<script src="vendors/popper.js/dist/umd/popper.min.js"></script>
<script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="dist/js/jquery.slimscroll.js"></script>
<script src="dist/js/dropdown-bootstrap-extended.js"></script>
<script src="vendors/jquery-toggles/toggles.min.js"></script>
<script src="dist/js/toggle-data.js"></script>
<script src="dist/js/init.js"></script>
</body>
</html>
