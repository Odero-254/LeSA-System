<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "nysei_lesa";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch lecturers and subjects
$lecturers = $conn->query("SELECT * FROM lecturers");
$subjects = $conn->query("SELECT * FROM subjects");

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manual Amendment</title>
</head>
<body>
    <h1>Manual Amendment of Subject Allocation</h1>
    <form method="POST" action="process_amendment.php">
        <label for="lecturer">Lecturer:</label>
        <select id="lecturer" name="lecturer_id">
            <?php while ($lecturer = $lecturers->fetch_assoc()) { ?>
                <option value="<?= $lecturer['id'] ?>"><?= $lecturer['name'] ?></option>
            <?php } ?>
        </select><br><br>

        <label for="subject">Subject:</label>
        <select id="subject" name="subject_id">
            <?php while ($subject = $subjects->fetch_assoc()) { ?>
                <option value="<?= $subject['id'] ?>"><?= $subject['name'] ?></option>
            <?php } ?>
        </select><br><br>

        <input type="submit" value="Amend Allocation">
    </form>
</body>
</html>
