<?php
// Check if session is not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('includes/config.php');

if (strlen($_SESSION['user_id']) == 0) {
    header('location: logout.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get user data from the previous form
    $_SESSION['user_data'] = $_POST;

    // Define roles manually since they are in the enum of user_role in users table
    $roles = [
        ['id' => 'Principal', 'name' => 'Principal'],
        ['id' => 'Deputy Principal', 'name' => 'Deputy Principal'],
        ['id' => 'HOD', 'name' => 'HOD'],
        ['id' => 'Lecturer', 'name' => 'Lecturer'],
        ['id' => 'Class Representative', 'name' => 'Class Representative'],
    ];

    // Fetch departments
    $departmentsQuery = "SELECT id, name FROM department";
    $departmentsResult = $conn->query($departmentsQuery);
    $departments = [];
    while ($row = $departmentsResult->fetch_assoc()) {
        $departments[] = $row;
    }

    // Fetch qualifications
    $qualificationsQuery = "SELECT id, qualifications FROM subjects";
    $qualificationsResult = $conn->query($qualificationsQuery);
    $qualifications = [];
    while ($row = $qualificationsResult->fetch_assoc()) {
        $qualifications[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Role and Department</title>
</head>
<body>
    <h3>Assign Role and Department</h3>
    <form action="add_user_step3.php" method="post">
        <div>
            <label for="role">Role</label>
            <select name="role" id="role" required onchange="showOptions(this.value)">
                <option value="">Select Role</option>
                <?php foreach ($roles as $role): ?>
                    <option value="<?php echo $role['id']; ?>"><?php echo $role['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div id="lecturerOptions" style="display:none;">
            <label for="qualifications">Qualifications (for Lecturers)</label>
            <div>
                <?php foreach ($qualifications as $qualification): ?>
                    <div>
                        <input type="checkbox" name="qualifications[]" value="<?php echo $qualification['id']; ?>">
                        <label><?php echo $qualification['qualifications']; ?></label>
                    </div>
                <?php endforeach; ?>
            </div>
            <label for="lecturer_department">Department</label>
            <select name="lecturer_department" id="lecturer_department">
                <?php foreach ($departments as $department): ?>
                    <option value="<?php echo $department['id']; ?>"><?php echo $department['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div id="hodOptions" style="display:none;">
            <label for="hod_department">Department (for HOD)</label>
            <select name="hod_department" id="hod_department">
                <?php foreach ($departments as $department): ?>
                    <option value="<?php echo $department['id']; ?>"><?php echo $department['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit">Next</button>
    </form>

    <script>
        function showOptions(roleId) {
            const lecturerOptions = document.getElementById('lecturerOptions');
            const hodOptions = document.getElementById('hodOptions');

            if (roleId === 'Lecturer') {
                lecturerOptions.style.display = 'block';
                hodOptions.style.display = 'none';
            } else if (roleId === 'HOD') {
                hodOptions.style.display = 'block';
                lecturerOptions.style.display = 'none';
            } else {
                lecturerOptions.style.display = 'none';
                hodOptions.style.display = 'none';
            }
        }
    </script>
</body>
</html>
