<?php
// Include your database configuration file
include 'includes/config.php';

// Initialize filter variable
$filter = isset($_POST['filter']) ? $_POST['filter'] : 'All';

// Prepare the query based on the filter
$query = "SELECT reschedules.id, lessons.lesson_name, classes.class_name, department.name AS department_name, 
          reschedules.reschedule_date, reschedules.reason, reschedules.timestamp
          FROM reschedules
          INNER JOIN lessons ON reschedules.lesson_id = lessons.id
          INNER JOIN classes ON reschedules.class_id = classes.id
          INNER JOIN department ON reschedules.department_id = department.id";

if ($filter !== 'All') {
    $query .= " WHERE department.name = ?";
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
    <title>Rescheduled Lessons Report</title>
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
        }
        .current-info div {
            margin: 0 15px;
        }
        .print-line {
            border: none;
            border-top: 2px solid green;
            margin: 10px 0;
        }
        @media print {
            .form-container, .buttons-container {
                display: none;
            }
            .print-line {
                display: block;
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
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.18/jspdf.plugin.autotable.min.js"></script>
</head>
<body>

<div class="logo">
    <img src="dist/img/comb_logo.png" alt="nysei LeSA Logo">
</div>

<div class="heading">
    Rescheduled Lessons Report
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
                echo '<option value="' . htmlspecialchars($row['name'], ENT_QUOTES) . '" ' . ($filter == $row['name'] ? 'selected' : '') . '>' . htmlspecialchars($row['name'], ENT_QUOTES) . '</option>';
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
                <th>Lesson Name</th>
                <th>Class Name</th>
                <th>Department</th>
                <th>Reschedule Date</th>
                <th>Reason</th>
                <th>Timestamp</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . htmlspecialchars($row['lesson_name'], ENT_QUOTES) . "</td>
                            <td>" . htmlspecialchars($row['class_name'], ENT_QUOTES) . "</td>
                            <td>" . htmlspecialchars($row['department_name'], ENT_QUOTES) . "</td>
                            <td>" . htmlspecialchars($row['reschedule_date'], ENT_QUOTES) . "</td>
                            <td>" . htmlspecialchars($row['reason'], ENT_QUOTES) . "</td>
                            <td>" . htmlspecialchars($row['timestamp'], ENT_QUOTES) . "</td>
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='6' class='no-data'>No rescheduled lessons found at the moment !!</td></tr>";
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
    pdf.text("Rescheduled Lessons Report", pdf.internal.pageSize.getWidth() / 2, 45, { align: "center" });

    // Add the current info (date, time, day)
    const date = document.getElementById('current-date').innerText;
    const time = document.getElementById('current-time').innerText;
    const day = document.getElementById('current-day').innerText;

    pdf.setFontSize(10);
    pdf.text(date, 20, 55);
    pdf.text(time, 70, 55);
    pdf.text(day, 120, 55);

    // Add table
    const table = document.querySelector('.table-container table');
    pdf.autoTable({ 
        html: table,
        startY: 60,
        margin: { horizontal: 10 },
        styles: {
            fontSize: 10,
            cellPadding: 2
        },
        headStyles: {
            fillColor: [173, 216, 230]
        }
    });

    // Save the PDF
    pdf.save('Rescheduled_Lessons_Report.pdf');
}
</script>

</body>
</html>
