<?php
require_once('fpdf/fpdf.php'); // Ensure this path is correct

// Database connection
include 'config.php';

// Fetch products from the database
$sql = "SELECT id, name, price FROM products";
$result = $conn->query($sql);
$products = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quotation Generator</title>
    <style>
          body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #e6f7ff; /* Light blue background */
            color: #333;
        }

        /* Form and Table */
        .container {
            max-width: 900px;
            margin: 40px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        .container:hover {
            transform: scale(1.02);
        }
        h1, h2 {
            color: #007acc;
        }
        label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }
        input[type="text"], input[type="email"], input[type="number"], select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"], button {
            background-color: #007acc;
            color: #fff;
            border: none;
            padding: 12px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover, button:hover {
            background-color: #005c99;
        }

        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #007acc;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #e0f3ff;
        }
        
        /* Add Product Button */
        button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 15px;
        }

        /* Remove Button */
        .remove-btn {
            background-color: red;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 12px;
        }

        .remove-btn:hover {
            background-color: darkred;
        }

    </style>
</head>
<body>

    <!-- Nav-Bar -->
    <?php include 'navbar.php'; ?>

    <div class="container">
        <h1>Quotation Generator</h1>
        <form action="generate_pdf.php" method="post">
            <h2>Customer Details</h2>
            <label for="customerName">Name:</label>
            <input type="text" name="customerName" required>

            <label for="customerAddress">Address:</label>
            <input type="text" name="customerAddress" required>

            <label for="customerPhone">Phone:</label>
            <input type="text" name="customerPhone" required>

            <label for="customerEmail">Email:</label>
            <input type="email" name="customerEmail" required>

            <h2>Product Details</h2>
            <table id="product-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Action</th>

                    </tr>
                </thead>
                <tbody id="product-container">
                    <tr class="product">
                        <td>
                            <select name="productId[]" required onchange="updatePrice(this)">
                                <option value="">Select a product</option>
                                <?php foreach ($products as $product): ?>
                                    <option value="<?php echo $product['id']; ?>" data-price="<?php echo $product['price']; ?>">
                                        <?php echo $product['name'] . ' - ₹' . number_format($product['price'], 2); ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td class="price">₹0.00</td>
                            <td>
                                <input type="number" name="quantity[]" required min="1" value="1" onchange="updateTotal(this)">
                            </td>
                            <td class="total">₹0.00</td>
                            <td><button type="button" class="remove-btn" onclick="removeProduct(this)">Remove</button></td>
                        </tr>
                    </tbody>
                </table>
            
            <button type="button" onclick="addProduct()">Add Another Product</button><br><br>
            <input type="submit" value="Generate Quotation">
        </form>
    </div>

    <script>
        function addProduct() {
    const productContainer = document.getElementById('product-container');
    const productRow = document.createElement('tr');
    productRow.classList.add('product');

    productRow.innerHTML = `
        <td>
            <select name="productId[]" required onchange="updatePrice(this)">
                <option value="">Select a product</option>
                <?php foreach ($products as $product): ?>
                    <option value="<?php echo $product['id']; ?>" data-price="<?php echo $product['price']; ?>">
                        <?php echo $product['name'] . ' - ₹' . number_format($product['price'], 2); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </td>
        <td class="price">₹0.00</td>
        <td>
            <input type="number" name="quantity[]" required min="1" value="1" onchange="updateTotal(this)">
        </td>
        <td class="total">₹0.00</td>
        <td><button type="button" class="remove-btn" onclick="removeProduct(this)">Remove</button></td>
    `;

    productContainer.appendChild(productRow);
}


        function updatePrice(select) {
            const priceCell = select.closest('tr').querySelector('.price');
            const totalCell = select.closest('tr').querySelector('.total');
            const quantityInput = select.closest('tr').querySelector('input[name="quantity[]"]');
            const price = parseFloat(select.options[select.selectedIndex].dataset.price) || 0;
            priceCell.textContent = `₹${price.toFixed(2)}`;
            updateTotal(quantityInput);
        }

        function updateTotal(input) {
            const row = input.closest('tr');
            const price = parseFloat(row.querySelector('.price').textContent.replace('₹', '')) || 0;
            const quantity = parseInt(input.value) || 0;
            const totalCell = row.querySelector('.total');
            const total = price * quantity;
            totalCell.textContent = `₹${total.toFixed(2)}`;
        }

        // Function to remove product row
        function removeProduct(button) {
            const row = button.closest('tr');
            row.remove();
        }
    </script>
</body>
</html>
