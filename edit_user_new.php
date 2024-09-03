<?php
// Check if a session is already started before starting a new one
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include('includes/config.php');
if (strlen($_SESSION['user_id']) == 0) {
    header('location:logout.php');
} else {
    // Code to fetch user details for editing
    if (isset($_GET['id'])) {
        $userid = substr(base64_decode($_GET['id']), 0, -5);
        $query = mysqli_query($conn, "SELECT * FROM users WHERE id='$userid'");
        $row = mysqli_fetch_array($query);

        if (isset($_POST['update'])) {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $phone_number = $_POST['phone_number'];
            $user_role = $_POST['user_role'];

            $query = mysqli_query($conn, "UPDATE users SET username='$username', email='$email', phone_number='$phone_number', user_role='$user_role', UpdationDate=NOW() WHERE id='$userid'");

            if ($query) {
                echo "<script>alert('User record updated successfully.');</script>";
                echo "<script>window.location.href='manage_users.php'</script>";
            } else {
                echo "<script>alert('Something went wrong. Please try again.');</script>";
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="dist/css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
    <!-- HK Wrapper -->
    <div class="hk-wrapper hk-vertical-nav">
        <!-- Top Navbar -->
        <?php include_once('includes/navbar.php'); ?>
        <?php include_once('includes/sidebar.php'); ?>

        <!-- Main Content -->
        <div class="hk-pg-wrapper">
            <!-- Container -->
            <div class="container">
                <!-- Title -->
                <div class="hk-pg-header">
                    <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="edit"></i></span></span>Edit User</h4>
                </div>
                <!-- /Title -->

                <!-- Row -->
                <div class="row">
                    <div class="col-xl-12">
                        <section class="hk-sec-wrapper">
                            <form method="post">
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control" id="username" name="username" value="<?php echo $row['username']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email Address</label>
                                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $row['email']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="phone_number">Phone Number</label>
                                    <input type="text" class="form-control" id="phone_number" name="phone_number" value="<?php echo $row['phone_number']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="user_role">Role</label>
                                    <select class="form-control" id="user_role" name="user_role" required>
                                        <option value="Admin" <?php echo ($row['user_role'] == 'Admin') ? 'selected' : ''; ?>>Admin</option>
                                        <option value="User" <?php echo ($row['user_role'] == 'User') ? 'selected' : ''; ?>>User</option>
                                        <option value="Moderator" <?php echo ($row['user_role'] == 'Moderator') ? 'selected' : ''; ?>>Moderator</option>
                                    </select>
                                </div>
                                <button type="submit" name="update" class="btn btn-primary">Update</button>
                                <a href="manage-users.php" class="btn btn-secondary">Cancel</a>
                            </form>
                        </section>
                    </div>
                </div>
                <!-- /Row -->
            </div>
            <!-- /Container -->
        </div>
        <!-- /Main Content -->
    </div>
    <!-- /HK Wrapper -->

    <script src="vendors/jquery/dist/jquery.min.js"></script>
    <script src="vendors/popper.js/dist/umd/popper.min.js"></script>
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="dist/js/init.js"></script>
</body>
</html>
<?php } ?>
