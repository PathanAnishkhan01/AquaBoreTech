<?php
session_start();

// Check if user is an admin
// This is a placeholder, replace with your own admin check logic
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    echo "Access denied.";
    exit();
}

// Connect to the database
include 'config.php';

// Fetch all orders
$sql = "SELECT * FROM orders ORDER BY order_date DESC";
$result = $conn->query($sql);

$orders = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Orders</title>
    <link rel="stylesheet" href="css\admin_orders.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
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
                <a class="nav-link" href="Aboutus.html">About Us</a>
            </li>
        </ul>
    </div>
    <div class="carts" style="margin-right: 40px;">
        <a href="cart.php"><i class="fa-solid fa-cart-shopping" style="font-size: larger;cursor: pointer;"></i></a>
    </div>
</nav>

<main class="content">
    <div class="container">
        <h2>Orders</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Order ID</th>
                    <th scope="col">User Email</th>
                    <th scope="col">Total Amount</th>
                    <th scope="col">Order Date</th>
                    <th scope="col">Details</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?php echo $order['id']; ?></td>
                    <td><?php echo $order['user_email']; ?></td>
                    <td>₹<?php echo $order['total_amount']; ?></td>
                    <td><?php echo $order['order_date']; ?></td>
                    <td><a href="order_details.php?order_id=<?php echo $order['id']; ?>">View Details</a></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>
</body>
</html>
