<?php
session_start();
include('../includes/config.php'); // Ensure the correct path

if (strlen($_SESSION['user_id']) == 0) {
    header('location:logout.php');
    exit();
} else {
    // Update last activity time to extend session
    $_SESSION['last_active_time'] = time();

    // Ensure $conn is defined
    if (!isset($conn)) {
        die("Database connection not established.");
    }

    // Fetch the department ID of the logged-in user
    $user_id = $_SESSION['user_id'];
    $userDeptQuery = $conn->prepare("SELECT department_id FROM users WHERE id = ?");
    $userDeptQuery->bind_param("i", $user_id);
    $userDeptQuery->execute();
    $userDeptQuery->bind_result($user_department_id);
    $userDeptQuery->fetch();
    $userDeptQuery->close();

    // Fetch users with the same department_id as the logged-in user
    $query = "SELECT users.id, users.username, users.email, users.phone_number, classes.class_name 
              FROM users 
              INNER JOIN classes ON users.class_id = classes.id
              WHERE users.department_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_department_id);
    $stmt->execute();
    $result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class Representatives Report</title>
    <link rel="stylesheet" href="../vendors/bootstrap/dist/css/bootstrap.min.css">
    <link href="../vendors/datatables.net-dt/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="../vendors/datatables.net-responsive-dt/css/responsive.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="../dist/css/style.css" rel="stylesheet" type="text/css">
    <style>
        .print-header, .print-footer {
            display: none;
        }
        @media print {
            .print-header, .print-footer {
                display: block;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <!-- Header with Logo -->
    <header class="text-center py-4 print-header">
        <img src="../dist/img/nyslogo.png" alt="Logo" width="100">
        <h3>National Youth Service</h3>
        <h3>Engineering Institute</h3> <br>
        <h4>Class Representatives Report</h4> 
        <hr>
    </header>

    <!-- Container -->
    <div class="container">
        <div class="table-wrap">
            <table id="datable_1" class="table table-hover w-100 display pb-30">
                <thead>
                    <tr>
                        <th>SNo</th>
                        <th>Full Name</th>
                        <th>Email Address</th>
                        <th>Phone Number</th>
                        <th>Class</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $cnt = 1;
                    while ($row = $result->fetch_assoc()) {    
                    ?>                                                
                    <tr>
                        <td><?php echo $cnt;?></td>
                        <td><?php echo $row['username'];?></td>
                        <td><?php echo $row['email'];?></td>
                        <td><?php echo $row['phone_number'];?></td>
                        <td><?php echo $row['class_name'];?></td>
                    </tr>
                    <?php 
                    $cnt++;
                    } ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center py-4 print-footer">
        <p>© 2024 NYS Engineering Institute. All rights reserved.</p>
    </footer>

    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <script src="../vendors/popper.js/dist/umd/popper.min.js"></script>
    <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../vendors/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../vendors/datatables.net-dt/js/dataTables.dataTables.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../vendors/jszip/dist/jszip.min.js"></script>
    <script src="../vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="../vendors/pdfmake/build/vfs_fonts.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="../vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../dist/js/dataTables-data.js"></script>
    <script src="../dist/js/feather.min.js"></script>
    <script src="../dist/js/dropdown-bootstrap-extended.js"></script>
    <script src="../vendors/jquery-toggles/toggles.min.js"></script>
    <script src="../dist/js/toggle-data.js"></script>
    <script src="../dist/js/init.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>
</body>
</html>
<?php
    // Close database connection
    $stmt->close();
    $conn->close();
}
?>
