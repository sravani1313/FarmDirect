<?php
// Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['fullname']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); 

    // Determine if the user is registering as a farmer
    $role = isset($_POST['role']) ? $_POST['role'] : 'user';
    $is_farmer = ($role === 'farmer') ? 1 : 0;

    // Check if email already exists
    $check_email = $conn->query("SELECT id FROM users WHERE email = '$email'");
    
    if ($check_email->num_rows > 0) {
        echo "<script>alert('Email already exists!'); window.location.href='/login.php';</script>";
    } else {
        // Updated INSERT statement to include is_farmer
        $sql = "INSERT INTO users (full_name, email, password, is_farmer) VALUES ('$name', '$email', '$password', $is_farmer)";
        
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Registration successful! Please login.'); window.location.href='/login.php';</script>";
        } else {
            // This displays the database error if the query fails
            echo "Database Error: " . $conn->error;
        }
    }
} else {
    echo "Invalid request method.";
}
$conn->close();
?>
