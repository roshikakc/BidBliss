<?php
include_once './Include/admin_header.php';

include 'database.php';
// session_start();
$admin_id =$_SESSION['admin_id'];

 if (!isset($admin_id)) {
    header('location:ad-login.php');
    exit;
}

if (isset($_POST['logout'])) {
    session_destroy();
    header('location:ad-login.php');
  exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="./assets/css/admin.css">
    <title>Home</title>
  
</head>
<body>
<div class="dynamic-content home">
    <div class="home-header">Dashboard</div>
    <section class="info-cards">
        <div class="card">
        <a href="admin_product.php">
            <?php
            // Count total products
            $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('Query failed');
            $num_of_products = mysqli_num_rows($select_products);
            ?>
            <h3><?php echo $num_of_products; ?></h3>
            <br><p>Total Products</p>
        </a>
        </div>

        <div class="card">
        <a href="admin_order.php">
            <?php
            // Count total orders
            $select_orders = mysqli_query($conn, "SELECT * FROM `orders`") or die('Query failed');
            $num_of_orders = mysqli_num_rows($select_orders);
            ?>
            <h3><?php echo $num_of_orders; ?></h3>
            <br><p>Total Orders</p>
        </a>
        </div>

        <div class="card">
        <a href="admin_user.php">
            <?php
            // Count total users
            $select_users = mysqli_query($conn, "SELECT * FROM `user`") or die('Query failed');
            $num_of_users = mysqli_num_rows($select_users);
            ?>
            <h3><?php echo $num_of_users; ?></h3>
            <br><p>Total Users</p>
        </a>
        </div>
    </section>
</div>

   
    <!-- <script>
    // Select necessary elements
    const sidebar = document.querySelector(".sidebar");
    const home = document.querySelector(".home");
    const toggleBtn = document.querySelector("#btn");

    // Sidebar toggle event
    toggleBtn.addEventListener("click", () => {
        sidebar.classList.toggle("open");

        // Adjust the home element dynamically
        if (sidebar.classList.contains("open")) {
            home.style.marginLeft = "200px"; // Sidebar's expanded width
            home.style.width = "calc(100% - 200px)";
        } else {
            home.style.marginLeft = "78px"; // Sidebar's collapsed width
            home.style.width = "calc(100% - 78px)";
        }
    });
</script> -->
<script src="./assets/js/script.js"></script>
</body>
</html>
 