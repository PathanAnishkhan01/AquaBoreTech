<?php
session_start();
include 'config.php';
$amount = 0;
// Check if the product ID is set in the URL
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Fetch product details from the database
    $sql = "SELECT * FROM products WHERE id = $product_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        $product['sizes'] = explode(',', $product['sizes']); // Convert sizes to an array
    } else {
        echo "Product not found!";
        exit;
    }

    // Fetch product reviews from the database
    $sql_reviews = "SELECT * FROM reviews WHERE product_id = $product_id";
    $reviews_result = $conn->query($sql_reviews);
    $reviews = [];
    if ($reviews_result->num_rows > 0) {
        while ($row = $reviews_result->fetch_assoc()) {
            $reviews[] = $row;
        }
    }

    // Fetch other products from the database
    $sql_other_products = "SELECT * FROM products WHERE id != $product_id LIMIT 4";
    $other_products_result = $conn->query($sql_other_products);
    $other_products = [];
    if ($other_products_result->num_rows > 0) {
        while ($row = $other_products_result->fetch_assoc()) {
            $other_products[] = $row;
        }
    }
} else {
    echo "No product ID provided!";
    exit;
}

// Handle form submission for adding a review
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['review_submit'])) {
    $username = $_POST['username'];
    $comment = $_POST['comment'];
    $rating = $_POST['rating'];

    $sql_insert = "INSERT INTO reviews (product_id, username, comment, rating) VALUES ($product_id, '$username', '$comment', $rating)";
    if ($conn->query($sql_insert) === TRUE) {
        // Refresh the page to show the new review
        header("Location: product_detail.php?id=$product_id");
        exit;
    } else {
        echo "Error: " . $sql_insert . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="logo-removebg.png" />
    <title><?php echo $product['name']; ?></title>
    <link rel="stylesheet" href="css/product_detail.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
</head>

<body>


    <!-- Nav-Bar -->
    <nav class="navbar navbar-expand-lg navbar-light pl-5 mt-2 font-weight-bold" style="background-color: rgb(235, 251, 251);">
        <!-- Navbar content -->
    </nav>

    <!-- Product Detail Page HTML -->
    <main class="content">
        <div class="container">
            <div class="product-detail">
                <img src="images/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" class="product-detail-img">
                <h1><?php echo $product['name']; ?></h1>
                <p><?php echo $product['description']; ?></p>
                <div class="price">₹<?php echo $product['price']; ?></div>
                <?php $amount = $product['price'] ?>
                <!-- Product Size Selection -->
                <div class="sizes">
                    <label for="size">Size:</label>
                    <select id="size" name="size" class="select-size">
                        <?php foreach ($product['sizes'] as $size): ?>
                            <option value="<?php echo $size; ?>"><?php echo $size; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Quantity Selection -->
                <div class="quantity-input">
                    <input type="number" name="quantity" value="1" min="1">
                </div>

                <!-- Add to Cart and Buy Now Buttons -->
                <form method="POST" action="add_to_cart.php" class="d-inline">
                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                    <input type="hidden" name="size" id="cart-size" value="">
                    <button type="submit" class="btn btn-primary">Add to Cart</button>
                </form>
                <div class="d-inline">
                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                    <input type="hidden" name="size" id="buy-size" value="">
                    <button type="button" id="payButton" class="btn btn-success">Buy Now</button>
                    </form>

                    <!-- Reviews Section -->
                    <div class="product-reviews">
                        <h2>Reviews</h2>
                        <?php if (!empty($reviews)): ?>
                            <?php foreach ($reviews as $review): ?>
                                <div class="review">
                                    <p><strong><?php echo $review['username']; ?>:</strong> <?php echo $review['comment']; ?></p>
                                    <p>Rating: <?php echo $review['rating']; ?>/5</p>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>No reviews yet.</p>
                        <?php endif; ?>
                    </div>

                    <!-- Review Form -->
                    <div class="review-form">
                        <h2>Leave a Review</h2>
                        <form method="POST" action="">
                            <div class="form-group">
                                <label for="username">Name:</label>
                                <input type="text" id="username" name="username" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="comment">Comment:</label>
                                <textarea id="comment" name="comment" class="form-control" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="rating">Rating:</label>
                                <select id="rating" name="rating" class="form-control" required>
                                    <option value="5">5</option>
                                    <option value="4">4</option>
                                    <option value="3">3</option>
                                    <option value="2">2</option>
                                    <option value="1">1</option>
                                </select>
                            </div>
                            <button type="submit" name="review_submit" class="btn btn-primary">Submit Review</button>
                        </form>
                    </div>
                </div>

                <!-- Other Products -->
                <div class="other-products">
                    <h2>Other Products</h2>
                    <div class="row">
                        <?php foreach ($other_products as $other_product): ?>
                            <div class="col-md-3">
                                <div class="product-card">
                                    <a href="product_detail.php?id=<?php echo $other_product['id']; ?>">
                                        <img src="images/<?php echo $other_product['image']; ?>" alt="<?php echo $other_product['name']; ?>" class="product-card-img">
                                        <h3><?php echo $other_product['name']; ?></h3>
                                        <div class="price">₹<?php echo $other_product['price']; ?></div>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
    </main>


    <?php include "footer.php"; ?>

    <script>
        document.querySelector('form[action="add_to_cart.php"]').addEventListener('submit', function() {
            document.getElementById('cart-size').value = document.getElementById('size').value;
        });
        document.querySelector('form[action="buy_now.php"]').addEventListener('submit', function() {
            document.getElementById('buy-size').value = document.getElementById('size').value;
        });
    </script>
    <script>
        document.getElementById('payButton').onclick = function(e) {
            var options = {
                "key": "rzp_test_xKpWOmC2HxLD0g", // Enter the Key ID generated from the Dashboard
                "amount": "<?php echo $amount * 100 ?>", // Amount is in currency subunits. Default currency is INR.
                "currency": "INR",
                "name": "Your Company Name",
                "description": "Purchase Description",
                "image": "https://yourdomain.com/your_logo.png",
                "handler": function(response) {
                    alert("Payment successful. Payment ID: " + response.razorpay_payment_id);
                    // Redirect to another page with order ID and amount as query parameters
                    window.location.href = "payment/payment_success.php?amount=" + options.amount + "&order_id=" + response.razorpay_payment_id;
                },
                "prefill": {
                    "name": "John Doe",
                    "email": "john.doe@example.com",
                    "contact": "9999999999"
                },
                "notes": {
                    "address": "Hello World"
                },
                "theme": {
                    "color": "#F37254"
                }
            };
            var rzp1 = new Razorpay(options);
            rzp1.open();
            e.preventDefault();
        }
    </script>
</body>

</html>