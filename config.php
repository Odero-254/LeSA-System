<?php
// Database configuration
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'nysei_lesa');

// Attempt to connect to MySQL database
$con = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check the connection
if ($con->connect_error) {
    die("ERROR: Could not connect. " . $con->connect_error);
}
?>
