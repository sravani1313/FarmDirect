<?php
// Force the use of environment variables
$host = getenv('DB_HOST');
$user = getenv('DB_USER');
$pass = getenv('DB_PASS');
$db   = getenv('DB_NAME');
$port = getenv('DB_PORT') ?: 3306;

// If any variable is missing, show a clear error
if (!$host || !$user || !$db) {
    die("Error: Database environment variables are not set in Render!");
}

// Create connection
$conn = mysqli_connect($host, $user, $pass, $db, $port);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>