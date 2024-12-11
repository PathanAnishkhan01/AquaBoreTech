<?php
include '../connection.php'; // Include the database connection
// session_start();

// Fetching data from the contactus table
$sq = "SELECT * FROM contactus";
$result = mysqli_query($conn, $sq);

// Handle multiple deletions
if (isset($_POST['delete_selected'])) {
    if (!empty($_POST['delete_ids'])) {
        $delete_ids = $_POST['delete_ids'];
        $id_list = implode(',', $delete_ids);

        // Delete selected queries from the database
        $sq = "DELETE FROM contactus WHERE id IN ($id_list)";
        $re = mysqli_query($conn, $sq);

        if ($re) {
            $_SESSION['message'] = "Selected queries deleted successfully";
        } else {
            $_SESSION['message'] = "Failed to delete selected queries";
        }
        // Redirect to refresh the page and display the message
        header("Location: cust_query.php");
        exit();
    } else {
        $_SESSION['message'] = "No queries selected for deletion";
        header("Location: cust_query.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Queries</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        

        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 50px;
        }
        table {
            margin: 20px auto;
            animation: fadeIn 1s ease-in-out;
        }
        .table th, .table td {
            text-align: center;
            vertical-align: middle;
        }
        .table-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        /* Animation for table */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
        .btn-action {
            margin-right: 5px;
        }
        .alert-success {
            animation: slideDown 1s ease-in-out;
        }
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

    </style>
</head>
<body>

<?php include 'admin_nav.php'; ?>

<div class="container">
    <h2 class="text-center my-4">Customer Queries</h2>

    <!-- Show success message if set -->
    <?php
    if (isset($_SESSION['message'])) {
        echo '<div class="alert alert-success" role="alert">' . $_SESSION['message'] . '</div>';
        unset($_SESSION['message']); // Clear the message after display
    }
    ?>

    <div class="table-container">
        <!-- Form to handle multiple deletions -->
        <form method="post" action="cust_query.php">
            <table class="table table-hover table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th scope="col"><input type="checkbox" id="select_all"></th> <!-- Select all checkbox -->
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Message</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetch data and display each row in the table
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '
                        <tr>
                            <td><input type="checkbox" name="delete_ids[]" value="' . $row['id'] . '"></td>
                            <th scope="row">' . $row['id'] . '</th>
                            <td>' . htmlspecialchars($row['name']) . '</td>
                            <td>' . htmlspecialchars($row['Email']) . '</td>
                            <td>' . htmlspecialchars($row['phone']) . '</td>
                            <td>' . nl2br(htmlspecialchars($row['Message'])) . '</td>
                            <td>
                                <a href="delete_query.php?id=' . $row['id'] . '" class="btn btn-danger btn-sm btn-action" onclick="return confirm(\'Are you sure you want to delete this query?\')">Delete</a>
                            </td>
                        </tr>';
                    }
                    ?>
                </tbody>
            </table>
            <!-- Button to delete selected items -->
            <button type="submit" name="delete_selected" class="btn btn-danger">Delete Selected</button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script>
    // JavaScript to handle "Select All" checkbox functionality
    document.getElementById('select_all').addEventListener('click', function() {
        var checkboxes = document.querySelectorAll('input[name="delete_ids[]"]');
        for (var checkbox of checkboxes) {
            checkbox.checked = this.checked;
        }
    });
</script>
</body>
</html>


