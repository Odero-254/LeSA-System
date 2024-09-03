<?php
// Check if a session is already started before starting a new one
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include('includes/config.php');
if (strlen($_SESSION['user_id']) == 0) {
    header('location:logout.php');
} else {

    // Update last activity time to extend session
    $_SESSION['last_active_time'] = time();

    // Code for deletion
    if (isset($_GET['del'])) {
        $userid = substr(base64_decode($_GET['del']), 0, -5);
        $query = mysqli_query($conn, "DELETE FROM users WHERE id='$userid'");
        echo "<script>alert('User record deleted.');</script>";
        echo "<script>window.location.href='manage-users.php'</script>";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Manage Users</title>
    <link rel="shortcut icon" href="dist/img/favicon.ico">
    <!-- Data Table CSS -->
    <link href="vendors/datatables.net-dt/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="vendors/datatables.net-responsive-dt/css/responsive.dataTables.min.css" rel="stylesheet" type="text/css" />
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
                    <li class="breadcrumb-item"><a href="#">Users</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Manage</li>
                </ol>
            </nav>
            <!-- /Breadcrumb -->

            <!-- Container -->
            <div class="container">
                <!-- Title -->
                <div class="hk-pg-header">
                    <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="database"></i></span></span>Manage Users</h4>
                </div>
                <!-- /Title -->

                <!-- Row -->
                <div class="row">
                    <div class="col-xl-12">
                        <section class="hk-sec-wrapper">
                            <div class="row">
                                <div class="col-sm">
                                    <div class="table-wrap">
                                        <table id="datable_1" class="table table-hover w-100 display pb-30">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Username</th>
                                                    <th>Email Address</th>
                                                    <th>Phone Number</th>
                                                    <th>Role</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
<?php
$loggedInUserId = $_SESSION['user_id'];
$rno = mt_rand(10000, 99999);
$query = mysqli_query($conn, "SELECT id, username, email, phone_number, user_role FROM users WHERE id != '$loggedInUserId'");
$cnt = 1;
while ($row = mysqli_fetch_array($query)) {
?>
                                                <tr>
                                                    <td><?php echo $cnt; ?></td>
                                                    <td><?php echo $row['username']; ?></td>
                                                    <td><?php echo $row['email']; ?></td>
                                                    <td><?php echo $row['phone_number']; ?></td>
                                                    <td><?php echo $row['user_role']; ?></td>
                                                    <td>
                                                        <a href="edit_user_new.php?id=<?php echo base64_encode($row['id'].$rno); ?>" class="mr-25" data-toggle="tooltip" data-original-title="Edit"> <i class="icon-pencil"></i></a>
                                                        <a href="manage_users.php?del=<?php echo base64_encode($row['id'].$rno); ?>" data-toggle="tooltip" data-original-title="Delete" onclick="return confirm('Do you really want to delete?');"> <i class="icon-trash txt-danger"></i> </a>
                                                    </td>
                                                </tr>
<?php 
$cnt++;
} 
?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
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
    <script src="dist/js/jquery.slimscroll.js"></script>
    <script src="vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="vendors/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="vendors/datatables.net-dt/js/dataTables.dataTables.min.js"></script>
    <script src="vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="vendors/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
    <script src="vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="vendors/jszip/dist/jszip.min.js"></script>
    <script src="vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="vendors/pdfmake/build/vfs_fonts.js"></script>
    <script src="vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="dist/js/dataTables-data.js"></script>
    <script src="dist/js/feather.min.js"></script>
    <script src="dist/js/dropdown-bootstrap-extended.js"></script>
    <script src="vendors/jquery-toggles/toggles.min.js"></script>
    <script src="dist/js/toggle-data.js"></script>
    <script src="dist/js/init.js"></script>
    <script>
        var inactiveTimeout = <?php echo 300; ?>;
        var idleTimer;

        function resetIdleTimer() {
            clearTimeout(idleTimer);
            idleTimer = setTimeout(logoutUser, inactiveTimeout * 1000);
        }

        function logoutUser() {
            window.location.href = 'auto_logout.php'; 
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
<?php } ?>
