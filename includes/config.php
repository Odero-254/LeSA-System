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
?>
