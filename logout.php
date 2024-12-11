
<?php
include 'connection.php';
session_start();

$_SESSION['email'] = "";
$_SESSION['uname'] = "";

header('location:index.php');
?>