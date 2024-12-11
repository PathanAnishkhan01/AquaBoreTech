<?php
include '../connection.php';
// session_start(); // Start session to use session variables

// Fetch search term from the request, if available
$searchTerm = isset($_POST['search']) ? $_POST['search'] : '';

// Initialize an empty array to store the search results
$users = [];

if (!empty($searchTerm)) {
    // Prepare SQL statement to search for users by username or email
    $sql = "SELECT * FROM user_regi WHERE username LIKE ? OR email LIKE ?";
    $stmt = $conn->prepare($sql);
    $likeTerm = '%' . $searchTerm . '%';
    $stmt->bind_param('ss', $likeTerm, $likeTerm);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch results into the $users array
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
    } else {
        echo "<p>Error: " . $conn->error . "</p>";
    }
    $stmt->close();
} else {
    // If no search term is entered, fetch all records
    $sql = "SELECT * FROM user_regi";
    $result = $conn->query($sql);

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
    } else {
        echo "<p>Error: " . $conn->error . "</p>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .table-container {
            margin: 30px auto;
            max-width: 800px;
        }

        .btn-action {
            margin-right: 5px;
        }
    </style>
</head>

<body>

    <?php include 'admin_nav.php'; ?>


    <div class="container table-container">
        <form action="index.php" method="post">
            <input
                type="text"
                name="search"
                placeholder="Search products..."
                value="<?php echo isset($searchTerm) ? htmlspecialchars($searchTerm) : ''; ?>"
                style="width: 250px; padding: 5px; margin-right: 5px; border-radius: 4px; border: 1px solid #ccc;">
            <button
                type="submit"
                style="background-color: rgb(255, 85, 51); color: white; width: 120px; padding: 5px; border-radius: 5px; border: none;">
                Search
            </button>
        </form>
        <h2 class="text-center my-4">Admin Dashboard - Manage Users</h2>

        <?php
        if (isset($_SESSION['message'])) {
            echo '<div class="alert alert-success" role="alert">' . $_SESSION['message'] . '</div>';
            unset($_SESSION['message']);
        }

        // Display the results in a table
        if (empty($users)) {
            echo '<p>No results found for the search term.</p>';
        } else {
            echo '<table class="table table-hover table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col"><input type="checkbox" id="select-all"> Select All</th>
                            <th scope="col">ID</th>
                            <th scope="col">Username</th>
                            <th scope="col">Email</th>
                            
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>';

            foreach ($users as $user) {
                echo '
                <tr>
                    <td><input type="checkbox" name="selected_ids[]" value="' . $user['id'] . '"></td>
                    <th scope="row">' . $user['id'] . '</th>
                    <td>' . htmlspecialchars($user['username']) . '</td>
                    <td>' . htmlspecialchars($user['email']) . '</td>
                    
                    <td>
                        <a href="update.php?id=' . $user['id'] . '" class="btn btn-primary btn-sm btn-action">Update</a>
                        <a href="delete.php?id=' . $user['id'] . '" class="btn btn-danger btn-sm btn-action" onclick="return confirm(\'Are you sure you want to delete this user?\')">Delete</a>
                    </td>
                </tr>';
            }

            echo '</tbody></table>';
        }
        ?>

        <script>
            // JavaScript to handle "Select All" functionality
            document.getElementById('select-all').onclick = function() {
                var checkboxes = document.getElementsByName('selected_ids[]');
                for (var checkbox of checkboxes) {
                    checkbox.checked = this.checked;
                }
            }
        </script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>