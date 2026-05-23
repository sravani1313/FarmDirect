<?php
session_start();
require 'db.php';

// Ensure the user is an admin and an ID is provided
if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1 && isset($_GET['id'])) {
    
    $id = intval($_GET['id']);
    
    // Securely delete the user
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    
    // THIS IS THE FIX: Redirect back to the customer list with a success message
    header("Location: customers_list.php?msg=deleted");
    exit();

} else {
    die("Access Denied.");
}
?>