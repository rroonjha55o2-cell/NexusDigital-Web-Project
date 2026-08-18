<?php
// Database connection configuration for local server
$host = "127.0.0.1";
$user = "root";
$pass = "root";
$dbname = "nexus_digital_db";

// Establish connection to MySQL database
$conn = new mysqli($host, $user, $pass, $dbname);

// Check database connection status
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
