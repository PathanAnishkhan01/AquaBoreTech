<?php
include '../connection.php'; // Include database connection

// Check if the query ID is passed
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete query from the contactus table
    $sq = "DELETE FROM contactus WHERE id = $id";
    if (mysqli_query($conn, $sq)) {
        // Redirect back to the cust_query.php page with a success message
        session_start();
        $_SESSION['message'] = "Query deleted successfully!";
        header('Location: cust_query.php');
    } else {
        // If deletion fails, set error message
        $_SESSION['message'] = "Error deleting query!";
        header('Location: cust_query.php');
    }
} else {
    // If no ID is passed, redirect back to cust_query.php
    header('Location: cust_query.php');
}
?>
