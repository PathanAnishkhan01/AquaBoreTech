<?php
include '../connection.php';
session_start();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $delete_query = "DELETE FROM user_regi WHERE id = $id";
    if (mysqli_query($conn, $delete_query)) {
        $_SESSION['message'] = "User deleted successfully.";
    } else {
        $_SESSION['message'] = "Error deleting user.";
    }
    header("Location: index.php"); // Redirect to dashboard
    exit();
}
?>
