<?php
include_once 'include/user_header.php';
include './../database.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Success</title>
    <link rel="stylesheet" href="./assets/css/user_style.css">  <!-- Include your existing styles -->
    <link rel="stylesheet" href="./assets/css/user.css">
</head>
<body>

<section class="success-message-container">
    <div class="success-message">
        <h2>Your order has been placed successfully!</h2>
        <p>Thank you for your purchase. We will notify you once your order is processed.</p>
        <button onclick="window.location.href='homepage.php'">Go to Homepage</button>
    </div>
</section>

</body>
</html>

<script src="./assets/js/main.js"></script>
<?php
include_once 'include/footer.php';
?>