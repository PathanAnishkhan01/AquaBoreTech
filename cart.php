<?php
session_start();

// Check if the cart is empty
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "Your cart is empty.";
    exit();
}

$cart = $_SESSION['cart'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <style>
        .cart-image {
            max-height: 100px;
            max-width: 100px;
            object-fit: cover;
        }
        .content {
            padding: 20px;
            align-item: center;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light pl-5 mt-2 font-weight-bold" style="background-color: rgb(235, 251, 251);">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item pr-4">
                <a class="nav-link" href="index.php">Home</a>
            </li>
            <li class="nav-item active pr-4">
                <a class="nav-link" href="products.php">Products <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item pr-4">
                <a class="nav-link" href="contactUs.php">Contact Us</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="aboutus.php">About Us</a>
            </li>
        </ul>
    </div>
    <?php
    if (empty($_SESSION['email'])) {
        echo "<div class='buttons' style='margin-left: 270px;'>
              <a target='_self' href='Sign_in.php' class='btn btn-outline-primary mr-3'>login</a>
              <a target='_self' href='Sign_up.php' class='btn btn-outline-primary mr-3'>signUp</a>
              </div>";
    } else {
        echo "<a target='_self' href='logout.php' class='btn btn-outline-primary mr-3'>logout</a>";
    }
    ?>
    <div class="carts" style="margin-right: 40px;">
        <a href="cart.php"><i class="fa-solid fa-cart-shopping" style="font-size: larger; cursor: pointer;"></i></a>
    </div>
</nav>

<main class="content">
    <div class="container">
        <h2>Your Cart</h2>
        <form method="post" action="update_cart.php">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Product</th>
                        <th scope="col">Name</th>
                        <th scope="col">Price</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Total</th>
                        <th scope="col">         </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total = 0;
                    foreach ($cart as $key => $item) {
                        $total_price = $item['price'] * $item['quantity'];
                        $total += $total_price;
                        $image = isset($item['image']) ? $item['image'] : 'default.jpg'; 
                        echo "<tr>
                                <td><img src='images/{$image}' alt='{$item['name']}' class='cart-image'></td>
                                <td>{$item['name']}</td>
                                <td>₹{$item['price']}</td>
                                <td>
                                    <input type='number' name='quantities[{$key}]' value='{$item['quantity']}' min='1'>
                                </td>
                                <td>₹{$total_price}</td>
                                <td>
                                    <button type='submit' name='update' value='{$key}' class='btn btn-sm btn-primary'>Update</button>
                                    <button type='submit' name='remove' value='{$key}' class='btn btn-sm btn-danger'>Remove</button>
                                </td>
                              </tr>";
                    }
                    ?>
                    <tr>
                        <td colspan="4" class="text-right"><strong>Total</strong></td>
                        <td><strong>₹<?php echo $total; ?></strong></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </form>
        <a href="checkout.php" class="btn btn-primary">Proceed to Checkout</a>
        <a href="products.php" class="btn btn-secondary">Continue Shopping</a>
    </div>
</main>
</body>
</html>
