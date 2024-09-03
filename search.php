<?php
require_once 'includes/config.php';
// include 'header.php';

$type = $_GET['type'] ?? null;
$department_id = $_GET['department'] ?? null;
$category = $_GET['category'] ?? null;
$class_id = $_GET['class'] ?? null;

$query = "";
$results = [];
$searchPerformed = false;

if ($type && $class_id) { // Check if a search was performed
    $searchPerformed = true;
    if ($type === 'missedLessons') {
        if ($category === 'students') {
            $query = "SELECT * FROM student_absence WHERE class_id = ?";
        } elseif ($category === 'lecturers') {
            $query = "SELECT * FROM attendance WHERE status = 'missed' AND class_id = ?";
        }
    } elseif ($type === 'Allocations') {
        $query = "SELECT * FROM allocations WHERE class_id = ?";
    }

    if ($query) {
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $class_id);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $results[] = $row;
        }
        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link rel="shortcut icon" href="dist/img/favicon.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #EDF0F1;
        }
        h1 {
            color: green;
            font-size: 24px;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
            display: flex;
            flex-direction: column;
        }
        .form-group label {
            font-weight: bold;
            margin-bottom: 5px;
        }
        .form-group input[type="text"],
        .form-group select {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 100%;
            box-sizing: border-box;
            margin-bottom: 10px;
        }
        .button-group {
            display: flex;
            justify-content: center;
            margin-top: 15px;
        }
        .button-group button {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            display: flex;
            align-items: center;
            margin-left: 20px;
        }
        .button-group button i {
            margin-right: 8px;
        }
        .button-group button:hover {
            background-color: #0056b3;
        }
        .left,
        .right {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            margin: 0;
        }
        .right {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
        }
        .search-results p {
            font-size: 18px;
            color: #333;
            text-align: center;
        }
        .search-results a {
            color: #007bff;
            text-decoration: none;
        }
        .search-results a:hover {
            text-decoration: underline;
        }

        @media(min-width: 768px) {
            .form-group {
                flex-direction: row;
                align-items: center;
                justify-content: space-between;
            }
            .form-group label {
                margin-right: 10px;
                white-space: nowrap;
                min-width: 95px;
                margin-bottom: 0;
            }
            .left {
                float: left;
                width: 25%;
                padding-right: 20px;
            }
            .right {
                float: left;
                width: 70%;
                padding-left: 20px;
            }
        }

        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
    </style>

    <script>
        function updateForm() {
            var type = document.getElementById('type').value;
            var department = document.getElementById('department');
            var category = document.getElementById('category');
            var classSelect = document.getElementById('class');
            department.innerHTML = '';
            category.innerHTML = '';
            classSelect.innerHTML = '<option value="" disabled selected>Select class</option>';

            if (type === 'missedLessons') {
                fetchDepartments();
                category.innerHTML = '<option value="" disabled selected>Select category</option>' +
                    '<option value="students">Students</option>' +
                    '<option value="lecturers">Lecturers</option>';
            } else if (type === 'Allocations') {
                fetchDepartments();
                category.innerHTML = '<option value="" disabled selected>Select Lecturer</option>';
            }
        }

        function fetchDepartments() {
            var department = document.getElementById('department');
            fetch('get_departments.php')
                .then(response => response.json())
                .then(data => {
                    department.innerHTML = '<option value="" disabled selected>Select department</option>';
                    data.forEach(function(dept) {
                        department.innerHTML += '<option value="' + dept.id + '">' + dept.name + '</option>';
                    });
                });
        }

        function updateClasses() {
            var departmentId = document.getElementById('department').value;
            var classSelect = document.getElementById('class');
            classSelect.innerHTML = '<option value="" disabled selected>Loading...</option>';

            fetch('get_classes_2.php?department_id=' + departmentId)
                .then(response => response.json())
                .then(data => {
                    classSelect.innerHTML = '<option value="" disabled selected>Select class</option>';
                    data.forEach(function(cls) {
                        classSelect.innerHTML += '<option value="' + cls.id + '">' + cls.class_name + '</option>';
                    });
                });
        }
    </script>
</head>
<body>
    <div class="clearfix">
        <div class="left">
            <form action="" method="get">
                <div class="form-group">
                    <label for="type">Type:</label>
                    <select id="type" name="type" onchange="updateForm()">
                        <option value="" disabled selected>Select category</option>
                        <option value="missedLessons" <?= ($type === 'missedLessons') ? 'selected' : ''; ?>>Track Missed Lessons</option>
                        <option value="Allocations" <?= ($type === 'Allocations') ? 'selected' : ''; ?>>Monitor Allocations</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="department">Department:</label>
                    <select id="department" name="department" onchange="updateClasses()">
                        <option value="" disabled selected>Select department</option>
                        <!-- Populate with PHP if required -->
                    </select>
                </div>
                <div class="form-group">
                    <label for="category">Category:</label>
                    <select id="category" name="category">
                        <option value="" disabled selected>Select category</option>
                        <!-- Dynamically populate based on Type -->
                    </select>
                </div>
                <div class="form-group">
                    <label for="class">Class:</label>
                    <select id="class" name="class">
                        <option value="" disabled selected>Select class</option>
                        <!-- Populate with PHP if required -->
                    </select>
                </div>
                <div class="button-group">
                    <button type="submit"><i class="fas fa-search"></i>Search</button>
                </div>
            </form>
        </div>
        <div class="right">
            <h1>Search Results</h1>
            <div class="search-results">
                <?php if ($searchPerformed): ?>
                    <?php if ($results): ?>
                        <?php foreach ($results as $row): ?>
                            <p><?= htmlspecialchars($row['course']) . " - " . htmlspecialchars($row['level']) . " (" . htmlspecialchars($row['start_time']) . " to " . htmlspecialchars($row['end_time']) . ")"; ?></p>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No results found.</p>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
