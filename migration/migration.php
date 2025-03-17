<?php

$host = "127.0.0.1:3307";
$user = "root";
$pass = "";
$db = "bidbliss";

$conn = new mysqli($host, $user, $pass);

if ($conn) {
    echo "Database Server connect success <br/>";

    try {
        $sql = "CREATE DATABASE $db";

        $result = $conn->query($sql);

        if ($result) {
            echo "Database has been created ($db) <br/>";
        } else {
            echo "Database has not been created <br/>";
        }
    } catch (Exception $e) {
        echo "Database already created ($db) <br/>";
    }

    // Connect database
    $conn = new mysqli($host, $user, $pass, $db);
    try {
        require_once "./database/cart.php";
    } catch (Exception $e) {
        echo "Table already Cart ($db) <br/>";
    }
    try {
        require_once "./database/products.php";
    } catch (Exception $e) {
        echo "Table already Products ($db) <br/>";
    }
    try {
        require_once "./database/user.php";
    } catch (Exception $e) {
        echo "Table already User ($db) <br/>";
    }
    try {
        require_once "./database/order.php";
    } catch (Exception $e) {
        echo "Table already order ($db) <br/>";
    }
   
} else {
    echo "not connect <br/>";
}
