<?php
session_start();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <link rel="stylesheet" href="./../../BidBliss/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <!-- Navbar -->
    <header>
        <div class="sidebar">
            <div class="logo">
                <img src="./assets/Image/BB.png" alt="logo" />
                <i class="fa-solid fa-bars" id="btn" aria-label="Toggle Sidebar"></i>
            </div>
            <nav>
                <ul class="nav-links">
                    <li><a href="admin_page.php"><i class="fa-solid fa-house"></i><span
                                class="link_name">Dashboard</span></a></li>
                    <li><a href="admin_product.php"><i class="fa-brands fa-product-hunt"></i><span
                                class="link_name">Product</span></a></li>
                    <li><a href="admin_order.php"><i class="fa-solid fa-cart-shopping"></i><span
                                class="link_name">Order</span></a></li>
                    <li><a href="admin_user.php"><i class="fa-regular fa-user"></i><span
                                class="link_name">User</span></a></li>
                </ul>
            </nav>
            <li class="profile">
                <div class="profile_details">
                    <div class="profile_contains">
                        <div class="name">rk</div>
                        <div class="email">roshika@gmail.com</div>
                    </div>
                    <a href="logout.php">
                        <i class="fa-solid fa-right-from-bracket" id="logout"></i>
                    </a>
                </div>

            </li>
        </div>

        <!-- <div class="home_section">
            <div class="text">Dashboard</div>
</div> -->
    </header>

</body>

</html>