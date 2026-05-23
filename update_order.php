<?php
session_start();
require 'db.php';

// Ensure the user is logged in as an admin
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    die("Access Denied.");
}

// Check if an ID was passed in the URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Update the status to 'Completed' safely using a prepared statement
    $stmt = $conn->prepare("UPDATE orders SET status = 'Completed' WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        // Send them back to the orders list with a success message
        header("Location: orders_list.php?msg=updated");
    } else {
        echo "Error updating order.";
    }
    $stmt->close();
} else {
    // If no ID is provided, just send them back to the list
    header("Location: orders_list.php");
}
?>