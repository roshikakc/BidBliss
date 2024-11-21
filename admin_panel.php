<?php
include 'database.php';
session_start();
$admin_id =$_SESSION['admin_name'];

 if (!isset($admin_id)) {
    header('location:login.php');
    exit;
}

if (isset($_POST['logout'])) {
    session_destroy();
    header('location:login.php');
  exit;
}
?>
