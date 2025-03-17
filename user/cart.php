<?php
include_once 'include/user_header.php';
include './../database.php';

if (!isset($_SESSION['user_id'])) {
    header('location: ./../ad-login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$message = "";

if (isset($_POST['add_to_cart']) && isset($_POST['product_id'])) {
    $product_id = intval($_POST['product_id']);

    // Verify if the product exists in the `products` table
    $product_check_query = "SELECT * FROM products WHERE product_id = '$product_id'";
    $product_check_result = mysqli_query($conn, $product_check_query);

    if (mysqli_num_rows($product_check_result) > 0) {
        // Check if the product is already in the cart
        $check_cart = mysqli_query($conn, "SELECT * FROM cart WHERE user_id='$user_id' AND pid='$product_id'");

        if (mysqli_num_rows($check_cart) > 0) {
            echo "Product already in cart!";
            header('Location: cart.php');
            exit;
        } else {
            // Insert into cart table
            $insert_cart = "INSERT INTO cart (user_id, pid, quantity) VALUES ('$user_id', '$product_id', 1)";
            if (mysqli_query($conn, $insert_cart)) {
                echo "Product added to cart!";
                header('Location: cart.php');
                exit;
            } else {
                echo "Failed to add product to cart. Please try again.";
                exit;
            }
        }
    } else {
        // If the product does not exist, display an error
        echo "The selected product does not exist.";
        // header('Location: homepage.php');
        exit;
    }
}

if (isset($_GET['delete'])) {
    $delete_id = intval($_GET['delete']); // Validate as integer
    $delete_query = "DELETE FROM cart WHERE cart_id = '$delete_id'";
    if (mysqli_query($conn, $delete_query)) {
        header('Location: cart.php');
        exit;
    } else {
        echo "Failed to delete item.";
    }
}

if (isset($_GET['delete_all'])) {
    $delete_all_query = "DELETE FROM cart WHERE user_id = '$user_id'";
    if (mysqli_query($conn, $delete_all_query)) {
        header('Location: cart.php');
        exit;
    } else {
        echo "Failed to delete all items.";
    }
}


// Fetch cart items with product details
$cart_items = mysqli_query($conn, "
    SELECT c.cart_id, c.quantity, p.product_name, p.product_image, 
           p.product_actual_price AS actual_price, p.product_latest_price AS latest_price
    FROM cart c
    JOIN products p ON c.pid = p.product_id
    WHERE c.user_id = '$user_id'") or die('Query failed');


// Calculate Total Price
$total_price = 0;
if (mysqli_num_rows($cart_items) > 0) {
    while ($item = mysqli_fetch_assoc($cart_items)) {
        $total_price += floatval($item['latest_price']) * intval($item['quantity']);
    }
}


// Handle Checkout Action
if (isset($_POST['checkout'])) {
    mysqli_query($conn, "DELETE FROM cart WHERE user_id = '$user_id'") or die('Query failed');
    $message = "Checkout successful! Your order is being processed.";
    header('location: homepage.php');
    exit;
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./assets/css/user_style.css">
    <link rel="stylesheet" href="./assets/css/user.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>
</head>

<body>
    <section class="shopping_cart">
        <h1>Products Added</h1>
        <?php if (!empty($message)): ?>
            <p class="message"><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>

        <div class="cart-container">
            <?php if (mysqli_num_rows($cart_items) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Actual Price</th>
                            <th>Latest Price</th>
                            <th>Quantity</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        mysqli_data_seek($cart_items, 0); // Reset pointer for reuse
                        while ($item = mysqli_fetch_assoc($cart_items)): ?>
                            <tr>
                                <td>
                                    <img src="./../image/<?php echo $item['product_image']; ?>" alt="Product Image" width="50">
                                    <?php echo htmlspecialchars($item['product_name']); ?>
                                </td>
                                <td>Rs. <?php echo number_format((float)$item['actual_price'], 2); ?>/-</td>
                                <td>Rs. <?php echo number_format((float)$item['latest_price'], 2); ?>/-</td>
                                <td><?php echo $item['quantity']; ?></td>
                                <td>
                                    <?php if (isset($item['cart_id']) && is_numeric($item['cart_id'])): ?>
                                        <form method="get" action="cart.php" style="display:inline;">
                                            <input type="hidden" name="delete" value="<?php echo $item['cart_id']; ?>">
                                            <button type="submit" onclick="return confirm('Are you sure you want to delete this item?');">Delete</button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>

                <h3>Total Price: Rs. <?php echo number_format($total_price, 2); ?>/-</h3>

                <!-- <form method="post" action="">
                    <button type="submit" name="checkout">Checkout</button>
                </form> -->

                <div class="cart-actions">
                    <!-- Checkout Button -->
                    <form method="post" action="" style="display:inline;">
                        <button type="submit" name="checkout" style="background-color: #4CAF50; color: white; ">Checkout</button>
                    </form>

                    <!-- Delete All Button -->
                    <form method="get" action="cart.php" style="display:inline;">
                        <input type="hidden" name="delete_all" value="1">
                        <button type="submit" onclick="return confirm('Are you sure you want to delete all items from the cart?');">Delete All</button>
                    </form>
                </div>
            <?php else: ?>
                <p>Your cart is empty!</p>
            <?php endif; ?>
        </div>
    </section>


</body>

</html>


<?php
include_once 'include/footer.php';
?>