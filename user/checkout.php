<?php
include_once 'include/user_header.php';
include './../database.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('location: ./../ad-login.php');
    exit;
}

if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to proceed to checkout.");
}

if (!isset($_GET['product_id'])) {
    die("Invalid request.");
}

$product_id = intval($_GET['product_id']);
$buyer_id = $_SESSION['user_id'];

// Fetch product details
$query = "SELECT * FROM products WHERE product_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product) {
    die("Product not found.");
}

$seller_id = $product['user_id']; // Get seller ID
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <link rel="stylesheet" href="./assets/css/user_style.css">
    <link rel="stylesheet" href="./assets/css/user.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

</head>
<body>

<section class="shopping cart">
<div class="cart-container">
    <h1>Checkout</h1>
    
    <!-- Product Details Table -->
    <table>
        <tr>
            <th>Product</th>
            <th>Price</th>
        </tr>
        <tr>
            <td>
        <img src="./../image/<?php echo htmlspecialchars($product['product_image']); ?>" width="80%" alt="Product Image">
            <?php echo htmlspecialchars($product['product_name']); ?></td>
            <td>Rs <?php echo htmlspecialchars($product['product_latest_price']); ?></td>
        </tr>
    </table>

    <!-- Confirmation Form -->
    <form id="userDetailsForm" action="conform_order.php" method="POST" style="display: none;">
        <h3>Enter Your Details</h3>
        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
        <input type="hidden" name="seller_id" value="<?php echo $seller_id; ?>">
        <input type="hidden" name="buyer_id" value="<?php echo $buyer_id; ?>">
        
        <label>Name:</label>
        <input type="text" name="name" required><br><br>
        
        <label>Address:</label>
        <input type="text" name="address" required><br><br>
        
        <label>Phone Number:</label>
        <input type="text" name="phone" required><br><br>
        
        <button type="submit" class="continue">Confirm Order</button>
    </form>

    <!-- Show Continue and Cancel buttons -->
     <div class="card-items" id="card-items">
    <button class="continue" onclick="showForm()">Continue</button>
    <button class="cancel" style="background-color: red; color: white;" onclick="window.location.href='homepage.php'">Cancel</button>

</div>
</div>
</section>

<script>
function showForm() {
    document.getElementById('userDetailsForm').style.display = 'block';
    document.getElementById('card-items').style.display = 'none';
}
</script>

</body>
</html>

<?php
include_once 'include/footer.php';
?>
