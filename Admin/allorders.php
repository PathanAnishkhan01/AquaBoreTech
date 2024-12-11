<?php

include '../config.php'; // Adjust this path as necessary
include 'admin_nav.php';

// Handle search query
$searchQuery = '';
if (isset($_GET['search'])) {
    $searchQuery = mysqli_real_escape_string($conn, $_GET['search']);
    $sql = "SELECT `name`, `order_id`, `amount` FROM `payments` WHERE `name` LIKE '%$searchQuery%' OR `order_id` LIKE '%$searchQuery%'";
} else {
    $sql = "SELECT `name`, `order_id`, `amount` FROM `payments`";
}

$result = mysqli_query($conn, $sql);

echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Records</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f9f9f9;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        table th {
            background-color: #f4f4f4;
            color: #333;
            font-weight: bold;
        }
        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        table tr:hover {
            background-color: #f1f1f1;
        }
        .search-container {
            margin-bottom: 20px;
        }
        .search-input {
            padding: 10px;
            width: 300px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .search-button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .search-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Payment Records</h1>

    <!-- Search Form -->
    <div class="search-container">
        <form method="GET" action="">
            <input type="text" name="search" value="' . htmlspecialchars($searchQuery) . '" class="search-input" placeholder="Search by Name or Order ID">
            <button type="submit" class="search-button">Search</button>
        </form>
    </div>
';

if (mysqli_num_rows($result) > 0) {
    echo '<table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Order ID</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>';

    while ($fetch = mysqli_fetch_assoc($result)) {
        echo '<tr>
            <td>' . htmlspecialchars($fetch['name']) . '</td>
            <td>' . htmlspecialchars($fetch['order_id']) . '</td>
            <td>' . htmlspecialchars($fetch['amount']) . '</td>
        </tr>';
    }

    echo '</tbody>
    </table>';
} else {
    echo '<p>No records found.</p>';
}

echo '</body>
</html>';
