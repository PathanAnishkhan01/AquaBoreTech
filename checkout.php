<?php
session_start();

// Debugging: Print the cart session data

// Check if the cart exists in the session
if (isset($_SESSION['cart'])) {
    $cart = $_SESSION['cart'];
    $selected_cart_items = [];

    // Only keep valid products
    foreach ($cart as $key => $value) {
        $selected_cart_items[$key] = $value;
    }

    // Debugging: Print selected cart items

    if (count($selected_cart_items) > 0) {
        $total = 0;
        echo "<h3>Checkout</h3>";
        echo "<ul>";
        foreach ($selected_cart_items as $item) {
            $total += $item['price'] * $item['quantity'];
            echo "<li>" . htmlspecialchars($item['name']) . " - ₹" . htmlspecialchars($item['price']) . " x " . htmlspecialchars($item['quantity']) . "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>No valid products selected for checkout. Please select at least one product with a quantity.</p>";
    }
} else {
    echo "<p>No products in the cart. Please add items to the cart before proceeding to checkout.</p>";
    exit();
}
