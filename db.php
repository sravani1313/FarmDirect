<?php
// Retrieve database credentials from environment variables
$host = getenv('DB_HOST') ?: 'localhost';
$user = getenv('DB_USER') ?: 'root';
$pass = getenv('DB_PASS') ?: ''; // Leave this empty for local development
$db   = getenv('DB_NAME') ?: 'farmdirect';

// Create connection
$conn = mysqli_connect($host, $user, $pass, $db);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>