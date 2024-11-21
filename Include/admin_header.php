<?php
 session_start();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <link rel="stylesheet" href="./../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <!-- Navbar -->
    <header>
        <div class="sidebar">
        <div class="logo">
            <img src="./assets/Image/BB.png" alt="logo">
        </div>
        <nav>
            <div class="nav-links">
                <ul>
                    <li><a href="admin_page.php">Home</a></li>
                    <li><a href="admin_product.php">Product</a></li>
                    <li><a href="admin_order.php">Order</a></li>
                    <li><a href="admin_user.php">User</a></li>
                    <li><a href="admin_message.php">Message</a></li>
                </ul>
            </div>
            <div class="admin">
                <ul>
                    <li><i class="fa-regular fa-user" id="user-btn"></i></a>
                    <div class="user-box">
                        
                        <p>username: <span><?php echo $_SESSION['admin_name'];?></span></p>
                        <p>Email: <span><?php echo $_SESSION['admin_email'];?></span></p>
                        <form method="post">
                            <button type="submit" class="logout-btn">log out</button>
                        </form>
                    </div>
                </li>
            </ul>
            <div class="menu">
            <ul>
            <li><i class="fa-solid fa-bars" id="menu-btn"></i></a></li>
        </ul>   
            </div> 
    </div>
        </nav>
        <div class="social_media">
            <a href="https://www.facebook.com"><i class="fab fa-facebook-f"></i></a>
        <a href="https://www.linkedin.com"><i class="fab fa-linkedin-in"></i></a>
        <a href="https://www.instagram.com"><i class="fab fa-instagram"></i></a>
        <a href="https://www.twitter.com"><i class="fab fa-twitter"></i></a>
       
        </div>
        </div>
     </header>

</body>
</html>