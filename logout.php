<?php
include 'database.php';

session_start();
session_destroy();

header('location:user/homepage.php');
?>