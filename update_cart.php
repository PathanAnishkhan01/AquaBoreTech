<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update'])) {
        // Update quantity
        $key = $_POST['update'];
        $quantity = $_POST['quantities'][$key];

        if ($quantity > 0 && isset($_SESSION['cart'][$key])) {
            $_SESSION['cart'][$key]['quantity'] = $quantity;
        }
    }

    if (isset($_POST['remove'])) {
        // Remove item from cart
        $key = $_POST['remove'];

        if (isset($_SESSION['cart'][$key])) {
            unset($_SESSION['cart'][$key]);
        }
    }
}

// Redirect back to the cart page
header("Location: cart.php");
exit();
?>
