<?php
// Check if session is not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once 'includes/config.php'; 

// Check if user is logged in
if (!isset($_SESSION['user_id'], $_SESSION['user_role'])) {
    header("Location: login.php");
    exit();
}

// Define user roles with their respective permissions
$allowed_roles = [
    'Principal' => ['generate_reports'],
    'Deputy Principal' => ['generate_reports'],
    'HOD' => ['generate_reports'],
    'Lecturer' => ['generate_reports'],
    'Class Representative' => ['generate_reports'],
];

// Check if current user has permission to generate reports
$user_role = $_SESSION['user_role'];
if (!in_array('generate_reports', $allowed_roles[$user_role])) {
    header("Location: unauthorized.php");
    exit();
}

// Initialize variables to store report data
$totalLessonsMissed = 0;
$totalStudentsMissed = 0;
$totalLecturersMissed = 0;
$mostAffectedClass = '';
$totalRescheduledLessons = 0; 

// Function to generate reports
function generateReport($reportType, $departmentId = null) {
    global $conn, $totalLessonsMissed, $totalStudentsMissed, $totalLecturersMissed, $mostAffectedClass, $totalRescheduledLessons;

    // Adjust query based on report type and department (if applicable)
    switch ($reportType) {
        case 'total_lessons_missed':
            $query = "SELECT COUNT(*) AS total FROM lessons WHERE status = 'missed'";
            break;
        case 'total_students_missed':
            $query = "SELECT COUNT(DISTINCT student_id) AS total FROM attendance WHERE status = 'missed'";
            break;
        case 'total_lecturers_missed':
            $query = "SELECT COUNT(DISTINCT lecturer_id) AS total FROM lessons WHERE status = 'missed'";
            break;
        case 'most_affected_class':
            $query = "SELECT class_id, COUNT(*) AS total_missed FROM lessons WHERE status = 'missed' GROUP BY class_id ORDER BY total_missed DESC LIMIT 1";
            break;
        case 'total_rescheduled_lessons':
            $query = "SELECT COUNT(*) AS total FROM lessons WHERE status = 'rescheduled'";
            break;
        default:
            return false; // Invalid report type
    }

    if ($departmentId !== null) {
        // Append department filter if provided (for HOD)
        $query .= " AND department_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $departmentId);
    } else {
        // For reports that do not require department filter
        $stmt = $conn->prepare($query);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        switch ($reportType) {
            case 'total_lessons_missed':
                $totalLessonsMissed = $row['total'];
                break;
            case 'total_students_missed':
                $totalStudentsMissed = $row['total'];
                break;
            case 'total_lecturers_missed':
                $totalLecturersMissed = $row['total'];
                break;
            case 'most_affected_class':
                $mostAffectedClass = $row['class_id'];
                break;
            case 'total_rescheduled_lessons':
                $totalRescheduledLessons = $row['total'];
                break;
            default:
                break;
        }
    }

    $stmt->close();
}

// Process form submission (if any)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    //Generate reports based on date range
    generateReport('total_lessons_missed');
    generateReport('total_students_missed');
    generateReport('total_lecturers_missed');
    generateReport('most_affected_class');
    generateReport('total_rescheduled_lessons'); 
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Generate Reports</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/datepickerjs@1.0.6/dist/datepicker.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
        }
        h2 {
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
        }
        form {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table th, table td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
        table th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Generate Reports</h2>
        <form method="post">
            <label>Select Date Range:</label><br>
            <label>Start Date:</label>
            <input type="text" id="start_date" name="start_date" autocomplete="off" required><br>
            <label>End Date:</label>
            <input type="text" id="end_date" name="end_date" autocomplete="off" required><br>
            <input type="submit" value="Generate Reports">
        </form>

        <h3>Reports for the Selected Period</h3>
        <table>
            <tr>
                <th>Total Lessons Missed</th>
                <td><?php echo $totalLessonsMissed; ?></td>
            </tr>
            <tr>
                <th>Total Students Who Missed Classes</th>
                <td><?php echo $totalStudentsMissed; ?></td>
            </tr>
            <tr>
                <th>Total Lecturers Who Missed Lessons</th>
                <td><?php echo $totalLecturersMissed; ?></td>
            </tr>
            <tr>
                <th>Most Affected Class (ID)</th>
                <td><?php echo $mostAffectedClass; ?></td>
            </tr>
            <tr>
                <th>Total Rescheduled Lessons</th>
                <td><?php echo $totalRescheduledLessons; ?></td>
            </tr>
        </table>
    </div>

    <!-- Include Datepicker.js library -->
    <script src="https://cdn.jsdelivr.net/npm/datepickerjs@1.0.6/dist/datepicker.min.js"></script>
    <script>
        // Initialize datepicker for start_date and end_date input fields
        const startDatePicker = datepicker('#start_date', {
            formatter: (input, date, instance) => {
                const value = date.toLocaleDateString();
                input.value = value;
            }
        });
        const endDatePicker = datepicker('#end_date', {
            formatter: (input, date, instance) => {
                const value = date.toLocaleDateString();
                input.value = value;
            }
        });
    </script>
</body>
</html>
