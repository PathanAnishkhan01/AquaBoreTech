<?php
// session_start();
include '../config.php'; // Adjust this path as necessary

//Delete Multiple items code
$messege = "";

$messege = "";

if (isset($_POST['delete_selected'])) {
    if (!empty($_POST['delete_ids'])) {
        $delete_ids = $_POST['delete_ids'];
        $id_list = implode(',', $delete_ids);

        // First, delete related reviews for these products
        $review_sql = "DELETE FROM reviews WHERE product_id IN ($id_list)";
        mysqli_query($conn, $review_sql);

        // Then, delete the products
        $sq = "DELETE FROM products WHERE id IN ($id_list)";
        $re = mysqli_query($conn, $sq);

        if ($re) {
            $messege = "Selected products deleted successfully";
        } else {
            $messege = "Failed to delete selected products";
        }
    } else {
        $messege = "No products selected for deletion";
    }
}

echo $messege; // Display message after deletion attempt


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action == 'add') {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $image = $_FILES['image']['name'];
        $target = "images/" . basename($image);

        $sql = "INSERT INTO products (name, description, price, image) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssds', $name, $description, $price, $image);

        if ($stmt->execute() && move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            echo "New product added successfully";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } elseif ($action == 'update') {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $image = $_FILES['image']['name'];
        $target = "images/" . basename($image);

        $sql = "UPDATE products SET name=?, description=?, price=?, image=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssdsi', $name, $description, $price, $image, $id);

        if ($stmt->execute() && move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            echo "Product updated successfully";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } elseif ($action == 'delete') {
        $id = $_POST['id'];

        // First, delete any related records in the reviews table
        $sql = "DELETE FROM reviews WHERE product_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->close();

        // Now, delete the product
        $sql = "DELETE FROM products WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $id);

        if ($stmt->execute()) {
            echo "Product deleted successfully";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }
}


// Fetch products from database
$products = [];
$sql = "SELECT * FROM products";
$result = $conn->query($sql);

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
} else {
    echo "<p>Error: " . $conn->error . "</p>";
}


$searchTerm = '';
$products = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search'])) {
    $searchTerm = $_POST['search'];
    $sql = "SELECT * FROM products WHERE name LIKE ? OR description LIKE ?";
    $stmt = $conn->prepare($sql);
    $likeTerm = '%' . $searchTerm . '%';
    $stmt->bind_param('ss', $likeTerm, $likeTerm);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $sql = "SELECT * FROM products";
    $result = $conn->query($sql);
}

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
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
    <title>Products Manage</title>
    <link rel="stylesheet" href="css/products-m.css">
</head>

<body>
    <?php include 'admin_nav.php'; ?>
    <div class="container">
        <h1>Products Manage</h1>
        <form id="productForm" action="productsmanage.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" id="productId">
            <input type="text" name="name" id="name" placeholder="Product Name" required>
            <textarea name="description" id="description" placeholder="Product Description" required></textarea>
            <input type="number" name="price" id="price" placeholder="Price" step="0.01" required>
            <input type="file" name="image" id="image" accept="image/*">
            <button type="submit" name="action" value="add">Add Product</button>
            <button type="submit" name="action" value="update">Update Product</button>
        </form>

        <form action="productsmanage.php" method="post">
            <input type="text" name="search" placeholder="Search products..." value="<?php echo htmlspecialchars($searchTerm); ?>" style="width: 250px;">
            <button type="submit" style="background-color: rgb(255, 85, 51); width: 120px; border-radius: 5px;">Search</button>
        </form>
        <h2>Product List</h2>
        <form method="post" action="productsmanage.php">
            <button type="submit" name="delete_selected">Delete Selected</button>
            <table>
                <thead>
                    <tr>
                        <th>Select</th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="productTable">
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><input type="checkbox" name="delete_ids[]" value="<?php echo $product['id']; ?>"></td>
                            <td><?php echo $product['id']; ?></td>
                            <td><?php echo $product['name']; ?></td>
                            <td><?php echo $product['description']; ?></td>
                            <td><?php echo $product['price']; ?></td>
                            <td><img src="images/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" width="200"></td>
                            <td>
                                <button onclick="editProduct(<?php echo $product['id']; ?>, '<?php echo $product['name']; ?>', '<?php echo $product['description']; ?>', <?php echo $product['price']; ?>, '<?php echo $product['image']; ?>')">Edit</button>
                                <form style="display:inline;" action="productsmanage.php" method="post">
                                    <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                                    <button type="submit" name="action" value="delete">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
    </div>
    <script>
        function editProduct(id, name, description, price, image) {
            document.getElementById('productId').value = id;
            document.getElementById('name').value = name;
            document.getElementById('description').value = description;
            document.getElementById('price').value = price;
            document.getElementById('image').value = image;
        }
    </script>
</body>

</html>