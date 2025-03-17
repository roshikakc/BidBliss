<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./assets/css/user_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>
    <nav class="navbar">
        <div class="container">
            <a href="./homepage.php" class="logo">
                <img src="./../assets/Image/BB.png " alt="Logo" />
            </a>

            <div class="toggle-button">
                <i class="fa-solid fa-bars"></i>
            </div>

            <ul class="nav-links">
                <li><a href="./fineart.php">Fine Arts</a></li>
                <li><a href="./jewellery.php">Jewellery</a></li>
                <li><a href="./collectable.php">Collectables</a></li>
                <li><a href="./decorativeart.php">Decorative Arts</a></li>
            </ul>

            <?php if (isset($_SESSION['user_id'])): ?>
                <!-- Show User Icon when logged in -->
                <div class="user-icon">
                    <a href="javascript:void(0)" class="user-profile">
                        <i class="fa-solid fa-user"></i>
                    </a>

                    <div class="dropdown-user-menu">
                        <a href="./profile.php" class="dropdown-user-item">Profile</a>
                        <a href="./../logout.php" class="dropdown-user-item">Logout</a>
                    </div>

                </div>
            <?php else: ?>
                <div class="auth-buttons">
                    <li><a href="./../ad-login.php" class="btn btn-signin">Sign In</a></li>
                    <li><a href="./../register.php" class="btn btn-register">Register</a></li>
                </div>
            <?php endif; ?>
        </div>

        <div class="dropdown_menu ">
            <li><a href="./fineart.php">Fine Arts</a></li>
            <li><a href="./jewellery.php">Jewellary</a></li>
            <li><a href="./collectable.php">Collectables</a></li>
            <li><a href="./decorativeart.php">Decorative Arts</a></li>

            <div class="dropdown-buttons">
                <li><a href="./../ad-login.php" class="btn btn-signin">Sign In</a></li>
                <li><a href="./../register.php" class="btn btn-register">Register</a></li>
            </div>
        </div>
    </nav>
    <script>
        // Get the user icon and dropdown menu
        const userIcon = document.querySelector('.user-icon');
        const dropdownMenu = document.querySelector('.dropdown-user-menu');

        // Add a click event to the user icon to toggle the dropdown
        userIcon.addEventListener('click', function(event) {
            event.stopPropagation(); // Prevent click from propagating to the body (optional)
            dropdownMenu.classList.toggle('open');
        });

        // Close the dropdown if user clicks anywhere outside of it
        document.body.addEventListener('click', function(event) {
            if (!userIcon.contains(event.target)) {
                dropdownMenu.classList.remove('open');
            }
        });
    </script>
</body>

</html>