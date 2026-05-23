<?php
session_start();
if(isset($_POST['product_id'])) {
    if(!isset($_SESSION['cart'])) { $_SESSION['cart'] = array(); }
    $_SESSION['cart'][] = $_POST['product_id'];
}
header("Location: cart.php"); // This MUST redirect to the new cart.php
exit();
?>