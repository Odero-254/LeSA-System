<?php
// Include your database configuration file
include 'includes/config.php';

$filter = isset($_POST['filter']) ? $_POST['filter'] : 'All';

// Prepare the query based on the filter
$query = "SELECT attendance.id, lecturers.username AS lecturer_name, subjects.subject_name, classes.class_name, 
          CONCAT(attendance.start_time, ' - ', attendance.end_time) AS lesson_time, 
          department.name AS department_name, attendance.day_of_week
          FROM attendance
          INNER JOIN lecturers ON attendance.lecturer_id = lecturers.id
          INNER JOIN subjects ON attendance.subject_id = subjects.id
          INNER JOIN classes ON attendance.class_id = classes.id
          INNER JOIN department ON attendance.department_id = department.id
          WHERE attendance.status = 'missed'";

if ($filter !== 'All') {
    $query .= " AND department.name = ?";
}

// Prepare and execute the query
$stmt = $conn->prepare($query);

if ($filter !== 'All') {
    $stmt->bind_param('s', $filter);
}

$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Missed Lessons Report</title>
    <link rel="shortcut icon" href="dist/img/favicon.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .logo {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }
        .logo img {
            max-width: 150px;
            height: auto;
        }
        .heading {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            font-weight: bold;
        }
        .current-info {
            display: flex;
            justify-content: center;
            margin-bottom: 10px;
            font-size: 18px;
            position: relative;
            margin-bottom: 20px; /* Adjust margin to create space between the line and the filter section */
        }
        .current-info div {
            margin: 0 15px;
        }

        .print-line {
            border: none;
            border-top: 2px solid green; /* Adjust thickness and color */
            margin: 10px 0; /* Space around the line */
        }

        @media print {
            .print-line {
                display: block; /* Ensure the line is visible in print */
            }
        }
        .form-container {
            margin-bottom: 20px;
            text-align: right;
        }
        .table-container {
            margin-bottom: 20px;
        }
        .table-container table {
            width: 100%;
            border-collapse: collapse;
        }
        .table-container th, .table-container td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .table-container th {
            background-color: #add8e6;
            font-weight: bold;
        }
        .no-data {
            color: red;
            font-weight: bold;
            text-align: center;
        }
        .buttons-container {
            margin-top: 30px;
            text-align: center;
        }
        .buttons-container button {
            margin-right: 10px;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 50px;
            display: inline-flex;
            align-items: center;
            cursor: pointer;
        }
        .buttons-container .btn-blue {
            background-color: #007bff;
            color: white;
            border: none;
        }
        .buttons-container .btn-green {
            background-color: #28a745;
            color: white;
            border: none;
        }
        .buttons-container .btn-grey {
            background-color: lightgrey;
            color: black;
            border: none;
        }
        .buttons-container .btn-blue i,
        .buttons-container .btn-green i,
        .buttons-container .btn-grey i {
            margin-right: 8px;
        }
        @media print {
            .form-container, .buttons-container {
                display: none;
            }
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.18/jspdf.plugin.autotable.min.js"></script>
</head>
<body>

<div class="logo">
    <img src="dist/img/comb_logo.png" alt="nysei LeSA Logo">
</div>

<div class="heading">
    Missed Lessons Report
</div>

<div class="current-info">
    <div id="current-date"></div>
    <div id="current-time"></div>
    <div id="current-day"></div>
</div>

<hr class="print-line">


<div class="form-container">
    <form method="post" action="">
        <label for="filter">Filter by Department:</label>
        <select name="filter" id="filter">
            <option value="All" <?php echo ($filter == 'All') ? 'selected' : ''; ?>>All</option>
            <!-- Populate departments dynamically -->
            <?php
            // Fetch all departments for the filter options
            $deptQuery = "SELECT name FROM department";
            $deptResult = $conn->query($deptQuery);
            while ($row = $deptResult->fetch_assoc()) {
                echo '<option value="' . $row['name'] . '" ' . ($filter == $row['name'] ? 'selected' : '') . '>' . $row['name'] . '</option>';
            }
            ?>
        </select>
        <button type="submit" class="btn-green"><i class="fas fa-filter"></i>Apply Filter</button>
    </form>
</div>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>Lecturer Name</th>
                <th>Subject Name</th>
                <th>Class Name</th>
                <th>Lesson Time</th>
                <th>Department</th>
                <th>Day</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['lecturer_name']}</td>
                            <td>{$row['subject_name']}</td>
                            <td>{$row['class_name']}</td>
                            <td>{$row['lesson_time']}</td>
                            <td>{$row['department_name']}</td>
                            <td>{$row['day_of_week']}</td>
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='6' class='no-data'>No missed lessons found at the moment !!</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<div class="buttons-container">
    <button class="btn-blue" onclick="window.print()"><i class="fas fa-print"></i>Print</button>
    <button class="btn-blue" onclick="downloadPDF()"><i class="fas fa-download"></i>Download</button>
    <button class="btn-grey" onclick="window.history.back()"><i class="fas fa-arrow-left"></i>Back</button>
</div>

<script>
function updateDateTime() {
    const now = new Date();
    const optionsDate = { year: 'numeric', month: 'long', day: 'numeric' };
    const optionsTime = { hour: '2-digit', minute: '2-digit', second: '2-digit' };
    const optionsDay = { weekday: 'long' };

    document.getElementById('current-date').innerText = `Date: ${now.toLocaleDateString(undefined, optionsDate)}`;
    document.getElementById('current-time').innerText = `Time: ${now.toLocaleTimeString(undefined, optionsTime)}`;
    document.getElementById('current-day').innerText = `Day: ${now.toLocaleDateString(undefined, optionsDay)}`;
}

updateDateTime();
setInterval(updateDateTime, 1000);

function downloadPDF() {
    const { jsPDF } = window.jspdf;
    const pdf = new jsPDF();

    // Add the logo and center it
    const imgData = document.querySelector('.logo img').src;
    const imgWidth = 30;
    const imgHeight = 30;
    const imgX = (pdf.internal.pageSize.getWidth() - imgWidth) / 2;
    pdf.addImage(imgData, 'PNG', imgX, 10, imgWidth, imgHeight);

    // Add the title
    pdf.setFontSize(18);
    pdf.text("Missed Lessons Report", pdf.internal.pageSize.getWidth() / 2, 45, { align: "center" });

    // Add the current info (date, time, day)
    const date = document.getElementById('current-date').innerText;
    const time = document.getElementById('current-time').innerText;
    const day = document.getElementById('current-day').innerText;

    pdf.setFontSize(12);
    pdf.text(date, 10, 60);
    pdf.text(time, pdf.internal.pageSize.getWidth() / 2, 60, { align: "center" });
    pdf.text(day, pdf.internal.pageSize.getWidth() - 10, 60, { align: "right" });

    // Draw the green line
    const lineY = 65; // Y position for the line, adjust as needed
    pdf.setDrawColor(0, 128, 0); // Set draw color to green (RGB: 0, 128, 0)
    pdf.setLineWidth(1); // Set line width
    pdf.line(10, lineY, pdf.internal.pageSize.getWidth() - 10, lineY); // Draw the line

    // Add the table content
    pdf.autoTable({
        startY: 70,
        html: '.table-container table',
        theme: 'striped'
    });

    pdf.save('missed_lessons_report.pdf');
}


</script>

</body>
</html>
