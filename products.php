<?php
// session_start();
include 'config.php';

// Initialize products array
$products = [];

// Fetch products from database
$sql = "SELECT * FROM products";
$result = $conn->query($sql);

if ($result) {
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
    } else {
        echo "<p>No products found in the database.</p>";
    }
} else {
    echo "<p>Error: " . $conn->error . "</p>";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="css/products.css">
    <link rel="icon" type="image/png" href="logo-removebg.png"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <script src="https://kit.fontawesome.com/yourcode.js" crossorigin="anonymous"></script>
</head>
<body>
<!-- Nav-Bar -->
<?php include 'navbar.php'; ?>

<main class="content">
    <div class="container">
        <div class="product-nav">
            <h2>Products</h2>
        </div>
        <div class="products-grid">
    <!-- Product Cards -->
    <?php if (!empty($products)): ?>
        <?php foreach ($products as $product): ?>
        <div class="product-card">
            <a href="product_detail.php?id=<?php echo $product['id']; ?>">
                <img src="images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="product-card-img">
                <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                <p><?php echo htmlspecialchars($product['description']); ?></p>
                <div class="price">₹<?php echo htmlspecialchars($product['price']); ?></div>
            </a>
            <form method="POST" action="add_to_cart.php">
                <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['id']); ?>">
                <input type="number" name="quantity" value="1" min="1" class="quantity-input">
                <button type="submit">Add to Cart</button>
            </form>
        </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No products found.</p>
    <?php endif; ?>
</div>
    </div>
</main>

<?php include "footer.php"; ?>
<script src="index.js"></script>

</body>
</html>
