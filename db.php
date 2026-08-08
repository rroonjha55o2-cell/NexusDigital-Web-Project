<?php
// Database Connection File
// Connects NexusDigital PHP application with MySQL Database
$host = "localhost";
$user = "root";
$pass = "";
$db   = "nexus_agency_db";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}
?>
