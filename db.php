<?php
// Database configuration
$db_host = 'localhost';
$db_name = 'madsensd_aiart';
$db_user = 'madsensd_madsen';
$db_pass = 'data2023';

// Create a new mysqli instance to connect to the database
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Check the connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Set the charset to utf8mb4
$conn->set_charset("utf8mb4");
?>