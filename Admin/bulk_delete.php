<?php
include '../connection.php';
session_start();

// Check if the delete_selected button was pressed and selected_ids is not empty
if (isset($_POST['delete_selected']) && isset($_POST['selected_ids'])) {
    // Get the array of selected IDs
    $selected_ids = $_POST['selected_ids'];

    // Prepare a list of IDs to delete
    $id_list = implode(",", $selected_ids);

    // SQL query to delete selected users
    $delete_query = "DELETE FROM user_regi WHERE id IN ($id_list)";
    
    if (mysqli_query($conn, $delete_query)) {
        $_SESSION['message'] = "Selected users deleted successfully.";
    } else {
        $_SESSION['message'] = "Error deleting selected users.";
    }
} else {
    $_SESSION['message'] = "No users selected for deletion.";
}

header("Location: index.php"); // Redirect to the admin dashboard
exit();
?>
