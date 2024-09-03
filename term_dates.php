<?php
include 'includes/config.php';

// Function to add or update the term dates
function setTermDates($termName, $startDate, $endDate) {
    global $conn;

    // Check if a term already exists
    $checkSql = "SELECT * FROM academic_terms WHERE term_name = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("s", $termName);
    $checkStmt->execute();
    $result = $checkStmt->get_result();
    $existingTerm = $result->fetch_assoc();
    $checkStmt->close();

    if ($existingTerm) {
        // Update the existing term
        $sql = "UPDATE academic_terms SET start_date = ?, end_date = ? WHERE term_name = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $startDate, $endDate, $termName);
    } else {
        // Insert a new term
        $sql = "INSERT INTO academic_terms (term_name, start_date, end_date) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $termName, $startDate, $endDate);
    }
    
    $stmt->execute();
    $stmt->close();
}

// Check for AJAX request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $termName = $_POST['term_name'];
    $startDate = $_POST['start_date'];
    $endDate = $_POST['end_date'];

    setTermDates($termName, $startDate, $endDate);

    $response = ['status' => 'success', 'message' => 'Term dates set successfully.'];
    header('Content-Type: application/json');
    echo json_encode($response);
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set Academic Term Dates</title>
</head>
<body>
    <h1>Set Academic Term Dates</h1>
    <form id="termDatesForm">
        <label for="term_name">Term Name:</label><br>
        <input type="text" id="term_name" name="term_name" required><br><br>
        <label for="start_date">Start Date:</label><br>
        <input type="date" id="start_date" name="start_date" required><br><br>
        <label for="end_date">End Date:</label><br>
        <input type="date" id="end_date" name="end_date" required><br><br>
        <button type="submit">Set Term Dates</button>
    </form>

    <script>
    document.getElementById('termDatesForm').addEventListener('submit', function(event) {
        event.preventDefault();

        const formData = new FormData(this);

        fetch('/path/to/term_dates.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
        })
        .catch(error => console.error('Error:', error));
    });
    </script>
</body>
</html>
