<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Prevent SQL injection by using modern parameterized prepared statements instead of real_escape_string
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // 1. Check for Hardcoded Admin Credentials First
    if ($email === 'admin@gmail.com' && $password === '123123') {
        // Look up the actual row in the database for this email to find its real auto-incremented ID
        $stmt = $conn->prepare("SELECT id, full_name, email, is_admin, is_farmer FROM users WHERE email = ? LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            
            // Populate actual database values into the session state
            $_SESSION['user_id'] = $user['id']; 
            $_SESSION['user_name'] = $user['full_name'];
            $_SESSION['email'] = $user['email']; // REQUIRED FOR PROFILE BACKUP IDENTIFICATION
            $_SESSION['is_admin'] = 1;
            $_SESSION['is_farmer'] = 0;
            
            echo "<script>alert('Welcome Admin!'); window.location.href='/admin_dashboard.php';</script>";
            exit();
        } else {
            // Fallback emergency configuration if the admin user isn't physically in the database table yet
            // This forces a match on email inside admin_profile.php as a fail-safe measure
            $_SESSION['user_id'] = null; 
            $_SESSION['user_name'] = 'Super Admin';
            $_SESSION['email'] = 'admin@gmail.com'; 
            $_SESSION['is_admin'] = 1;
            $_SESSION['is_farmer'] = 0;
            
            echo "<script>alert('Welcome Admin (Fallback Session Mode)!'); window.location.href='/admin_dashboard.php';</script>";
            exit();
        }
    }

    // 2. Secure Database Verification for standard users, farmers, and registered admins
    $stmt = $conn->prepare("SELECT id, full_name, email, password, is_admin, is_farmer FROM users WHERE email = ? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['full_name'];
            $_SESSION['email'] = $user['email']; // Sync email value to session tracking state
            $_SESSION['is_admin'] = $user['is_admin']; 
            $_SESSION['is_farmer'] = $user['is_farmer']; 
            
            // Route users dynamically based on corporate/customer role tags
            if ($user['is_admin'] == 1) {
                echo "<script>alert('Welcome Admin!'); window.location.href='/admin_dashboard.php';</script>";
            } elseif ($user['is_farmer'] == 1) {
                echo "<script>alert('Welcome Farmer!'); window.location.href='/farmer_dashboard.php';</script>";
            } else {
                echo "<script>alert('Login successful!'); window.location.href='/account.php';</script>";
            }
            exit();
        } else {
            echo "<script>alert('Incorrect password!'); window.location.href='/login.php';</script>";
            exit();
        }
    } else {
        echo "<script>alert('User not found!'); window.location.href='/login.php';</script>";
        exit();
    }
}
$conn->close();
?>
