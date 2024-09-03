<?php
// Check if session is not started
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
        $query = mysqli_query($conn, "delete from users where id='$userid'");
        echo "<script>alert('User record deleted.');</script>";   
        echo "<script>window.location.href='manage_user.php'</script>";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Manage Users</title>
    <link rel="shortcut icon" href="dist/img/favicon.ico">
    <link href="vendors/datatables.net-dt/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="vendors/datatables.net-responsive-dt/css/responsive.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="vendors/jquery-toggles/css/toggles.css" rel="stylesheet" type="text/css">
    <link href="vendors/jquery-toggles/css/themes/toggles-light.css" rel="stylesheet" type="text/css">
    <link href="dist/css/style.css" rel="stylesheet" type="text/css">
    <style>
        .form-popup {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }
        .form-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            max-width: 400px;
            margin: auto;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .form-container h2 {
            text-align: center;
        }
        .form-container input[type="text"], .form-container input[type="email"], .form-container input[type="tel"], .form-container input[type="date"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-container .btn {
            background-color: #00acf0;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            margin: 10px 0;
        }
        .form-container .cancel {
            background-color: red;
        }
        .form-container .btn:hover {
            background-color: #007bb5;
        }
        .form-container .cancel:hover {
            background-color: darkred;
        }
        .table-row-link {
            cursor: pointer;
        }
    </style>
</head>
<body>
    <!-- HK Wrapper -->
    <div class="hk-wrapper hk-vertical-nav">
        <!-- Top Navbar -->
        <?php include_once('includes/navbar.php'); include_once('includes/sidebar.php'); ?>
        <div id="hk_nav_backdrop" class="hk-nav-backdrop"></div>
        <!-- Main Content -->
        <div class="hk-pg-wrapper">
            <!-- Breadcrumb -->
            <nav class="hk-breadcrumb" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-light bg-transparent">
                    <li class="breadcrumb-item"><a href="home.php">Users</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Manage</li>
                </ol>
            </nav>
            <!-- Container -->
            <div class="container">
                <!-- Title -->
                <div class="hk-pg-header">
                    <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="database"></i></span></span>Manage Users</h4>
                </div>
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
                                                    <th>SNo</th>
                                                    <th>Name</th>
                                                    <th>Email Address</th>
                                                    <th>Phone Number</th>
                                                    <th>Role</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $rno = mt_rand(10000, 99999);  
                                                $query = mysqli_query($conn, "select * from users");
                                                $cnt = 1;
                                                while ($row = mysqli_fetch_array($query)) {    
                                                ?>                                                
                                                <tr class="table-row-link" data-id="<?php echo $row['id']; ?>" data-username="<?php echo $row['username']; ?>" data-email="<?php echo $row['email']; ?>" data-phone="<?php echo $row['phone_number']; ?>" data-department="<?php echo $row['user_role']; ?>">
                                                    <td><?php echo $cnt;?></td>
                                                    <td><?php echo $row['username'];?></td>
                                                    <td><?php echo $row['email'];?></td>
                                                    <td><?php echo $row['phone_number'];?></td>
                                                    <td><?php echo $row['user_role'];?></td>
                                                    <td>   
                                                    <a href="edit_user_2.php?id=<?php echo $row['id']; ?>" data-toggle="tooltip" data-original-title="Edit"><i class="icon-pencil"></i></a>
                                                        <a href="manage_user.php?del=<?php echo base64_encode($row['id'].$rno);?>" data-toggle="tooltip" data-original-title="Delete" onclick="return confirm('Do you really want to delete?');"> <i class="icon-trash txt-danger"></i> </a>
                                                    </td>
                                                </tr>
                                                <?php 
                                                $cnt++;
                                                } ?>
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

    <!-- Edit Form Popup -->
    <div class="form-popup" id="editForm">
        <form action="/submit_info" class="form-container" method="POST">
            <h2>Edit Information</h2>

            <label for="name"><b>Name</b></label>
            <input type="text" placeholder="Enter Name" name="name" id="name" required>

            <label for="email"><b>Email</b></label>
            <input type="email" placeholder="Enter Email" name="email" id="email" required>

            <label for="phone"><b>Phone Number</b></label>
            <input type="tel" placeholder="Enter Phone Number" name="phone" id="phone" required>

            <label for="department"><b>Department</b></label>
            <input type="text" placeholder="Enter Department" name="department" id="department" required>

            <input type="hidden" name="user_id" id="user_id">

            <button type="submit" class="btn">Save</button>
            <button type="button" class="btn cancel" onclick="closeForm()">Close</button>
        </form>
    </div>

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
        // Open the form and populate it with data
        document.querySelectorAll('.table-row-link').forEach(row => {
            row.addEventListener('click', function() {
                document.getElementById('name').value = this.dataset.username;
                document.getElementById('email').value = this.dataset.email;
                document.getElementById('phone').value = this.dataset.phone;
                document.getElementById('department').value = this.dataset.department;
                document.getElementById('user_id').value = this.dataset.id;
                document.getElementById('editForm').style.display = 'flex';
            });
        });

        // Close the form
        function closeForm() {
            document.getElementById('editForm').style.display = 'none';
        }

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
