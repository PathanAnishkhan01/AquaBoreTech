<?php
session_start();

if (!isset($_SESSION['email']) || empty($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // Connect to the database
    include 'config.php';

    // Fetch the product details
    $sql = "SELECT * FROM products WHERE id = $product_id";
    $result = $conn->query($sql);
    $product = $result->fetch_assoc();

    if (!$product) {
        die("Product not found.");
    }

    // Prepare cart item
    $cart_item = [
        'id' => $product['id'],
        'image' => $product['image'],
        'name' => $product['name'],
        'price' => $product['price'],
        'quantity' => $quantity,
    ];

    // Check if cart already exists in session
    if (isset($_SESSION['cart'])) {
        $cart = $_SESSION['cart'];
    } else {
        $cart = [];
    }

    // Check if product is already in the cart
    $product_exists = false;
    foreach ($cart as &$item) {
        if ($item['id'] == $product_id) {
            $item['quantity'] += $quantity;
            $product_exists = true;
            break;
        }
    }

    // If product does not exist in the cart, add it
    if (!$product_exists) {
        $cart[] = $cart_item;
    }

    // Save cart back to session
    $_SESSION['cart'] = $cart;

    // Redirect to cart page
    header("Location: cart.php");
    exit();
}
?>
