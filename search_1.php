<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Lessons</title>
    <link rel="stylesheet" href="style3.css">
</head>
<body>

<?php
// Check if session is not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('includes/config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search'])) {
    $type = $_POST['type'];
    $department = $_POST['department'];
    $category = $_POST['category'];
    $class = $_POST['class'];

    if ($type == "track_lesson") {
        if ($category == "students") {
            $query = "SELECT * FROM student_absence WHERE class_id IN (SELECT id FROM classes WHERE class_name='$class')";
        } elseif ($category == "lecturers") {
            $query = "SELECT * FROM attendance WHERE status='missed' AND lecturer_id IN (SELECT id FROM lecturers WHERE username='$category')";
        }
    } elseif ($type == "view_allocations") {
        $query = "SELECT * FROM allocations WHERE lecturer_id IN (SELECT id FROM lecturers WHERE username='$category')";
    }

    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        echo '<div id="results"><h2>Results:</h2>';
        echo '<table border="1">';
        echo '<tr><th>ID</th><th>Details</th></tr>';
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            echo '<td>' . $row['id'] . '</td>';
            echo '<td>' . $row['details'] . '</td>';  // Adjust according to your table structure
            echo '</tr>';
        }
        echo '</table></div>';
    } else {
        echo '<div id="results"><h2>No results found.</h2></div>';
    }
}
?>

    <h1>Search Lessons</h1>
    <div class="form-container">
        <form id="searchForm" method="POST" action="">
            <label for="type">Type:</label>
            <select name="type" id="type" onchange="populateDepartments()" required>
                <option value="">Select Type</option>
                <option value="track_lesson">Track Missed Lessons</option>
                <option value="view_allocations">View Lesson Allocations</option>
            </select>

            <label for="department">Department:</label>
            <select name="department" id="department" onchange="populateCategory()" required>
                <option value="">Select Department</option>
                <!-- Departments will be populated dynamically -->
            </select>

            <label for="category">Category:</label>
            <select name="category" id="category" onchange="populateClass()" required>
                <option value="">Select Category</option>
                <!-- Category options will be populated dynamically -->
            </select>

            <label for="class">Class:</label>
            <select name="class" id="class" required>
                <option value="">Select Class</option>
                <!-- Classes will be populated dynamically -->
            </select>

            <button type="submit" name="search">Search</button>
        </form>

        <div class="results-container" id="results">
            <!-- Results will be displayed here -->
        </div>
    </div>

    <script>
        function populateDepartments() {
            var type = document.getElementById("type").value;
            var departmentDropdown = document.getElementById("department");

            // Clear previous options
            departmentDropdown.innerHTML = '<option value="">Select Department</option>';

            if (type === "track_lesson" || type === "view_allocations") {
                // Fetch departments from the database (using AJAX or you can use PHP directly to populate)
                <?php
                include('includes/config.php');
                $departments = mysqli_query($conn, "SELECT name FROM department");
                while ($row = mysqli_fetch_assoc($departments)) {
                    echo 'departmentDropdown.innerHTML += "<option value=\'' . $row['name'] . '\'>' . $row['name'] . '</option>";';
                }
                ?>
            }
        }

        function populateCategory() {
            var type = document.getElementById("type").value;
            var categoryDropdown = document.getElementById("category");

            // Clear previous options
            categoryDropdown.innerHTML = '<option value="">Select Category</option>';

            if (type === "track_lesson") {
                categoryDropdown.innerHTML += '<option value="students">Students</option>';
                categoryDropdown.innerHTML += '<option value="lecturers">Lecturers</option>';
            } else if (type === "view_allocations") {
                // Fetch lecturers based on department
                var department = document.getElementById("department").value;
                <?php
                if (isset($_POST['department'])) {
                    $department = $_POST['department'];
                    $lecturers = mysqli_query($conn, "SELECT username FROM lecturers WHERE department_id IN (SELECT id FROM department WHERE name='$department')");
                    while ($row = mysqli_fetch_assoc($lecturers)) {
                        echo 'categoryDropdown.innerHTML += "<option value=\'' . $row['username'] . '\'>' . $row['username'] . '</option>";';
                    }
                }
                ?>
            }
        }

        function populateClass() {
            var department = document.getElementById("department").value;
            var classDropdown = document.getElementById("class");

            // Clear previous options
            classDropdown.innerHTML = '<option value="">Select Class</option>';

            // Fetch classes based on department and category
            <?php
            if (isset($_POST['department']) && isset($_POST['category'])) {
                $department = $_POST['department'];
                $category = $_POST['category'];
                $classes = mysqli_query($conn, "SELECT class_name FROM classes WHERE department_id IN (SELECT id FROM department WHERE name='$department')");
                while ($row = mysqli_fetch_assoc($classes)) {
                    echo 'classDropdown.innerHTML += "<option value=\'' . $row['class_name'] . '\'>' . $row['class_name'] . '</option>";';
                }
            }
            ?>
        }
    </script>
</body>
</html>
