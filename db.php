<?php
$host = "localhost";
// Put your MySQL Workbench username inside the quotes below (usually it is "root")
$username = "root"; 

// Put your MySQL Workbench password inside the quotes below
// Even if it has an @ symbol, the quotes will keep it safe!
$password = "Sravani@777"; 

$dbname = "farmdirect";

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>