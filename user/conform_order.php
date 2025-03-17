<?php
include './../database.php';
session_start();

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to place an order.");
}

// Ensure request is POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $product_id = intval($_POST['product_id']);
    $seller_id = intval($_POST['seller_id']);
    $buyer_id = intval($_POST['buyer_id']);
    $customer_name = mysqli_real_escape_string($conn, $_POST['name']);
    $customer_address = mysqli_real_escape_string($conn, $_POST['address']);
    $customer_phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $status = "Pending"; // Default status

    // Insert order into database
    $query = "INSERT INTO orders (product_id, seller_id, buyer_id, customer_name, customer_address, customer_phone, status) 
              VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($query);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("iiissss", $product_id, $seller_id, $buyer_id, $customer_name, $customer_address, $customer_phone, $status);

    if ($stmt->execute()) {
        echo "Order placed successfully!";
        header("Location: success.php");
        exit();
    } else {
        die("Database Error: " . $stmt->error);
    }

    $stmt->close();
}
?>
