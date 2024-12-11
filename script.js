// script.js
document.getElementById('addItem').addEventListener('click', function() {
    const itemsDiv = document.getElementById('items');
    const newItem = document.createElement('div');
    newItem.classList.add('item');
    newItem.innerHTML = `
        <select name="productId[]" required>
            <option value="">Select Product</option>
            <?php
            // This PHP block is to be filled with the same product options as above
            $result->data_seek(0); // Reset pointer to the beginning
            while ($row = $result->fetch_assoc()) {
                echo '<option value="' . $row['id'] . '">' . $row['name'] . ' (' . $row['size'] . ') - $' . $row['price'] . '</option>';
            }
            ?>
        </select>
        <input type="number" name="quantity[]" placeholder="Quantity" required>
    `;
    itemsDiv.appendChild(newItem);
});