<?php
session_start();
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $category = $conn->real_escape_string($_POST['category']);
    $price = $_POST['price'];
    $unit = $conn->real_escape_string($_POST['unit']);
    $stock = $_POST['stock'];
    $description = $conn->real_escape_string($_POST['description']);
    
    // Placeholder image
    $image_url = "https://images.unsplash.com/photo-1592924357228-91a4daadcfea?auto=format&fit=crop&w=500&q=60"; 

    $sql = "INSERT INTO products (name, category, price, unit, stock, description, image_url) 
            VALUES ('$name', '$category', '$price', '$unit', '$stock', '$description', '$image_url')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Product Added Successfully!'); window.location.href='products.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
$conn->close();
?>