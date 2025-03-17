<?php
include_once 'include/user_header.php';
include './../database.php';

$is_featured = 0;
$auction_date = null;

// Handle form submission for updating the product
if (isset($_POST['update_product'])) {
    $update_id = $_POST['update_id'];
    $product_name = mysqli_real_escape_string($conn, $_POST['name']);
    $product_price = mysqli_real_escape_string($conn, $_POST['price']);
    $product_detail = mysqli_real_escape_string($conn, $_POST['product_detail']);
    $product_category = mysqli_real_escape_string($conn, $_POST['product_category']);
    $auction_type = $_POST['auctionType1'];

    if ($auction_type == 'featured') {
        $is_featured = 1;
        $auction_date = null;
    } elseif ($auction_type == 'upcoming') {
        $auction_date = mysqli_real_escape_string($conn, $_POST['auctionDate']);
    }
    
    $auction_end_time = isset($_POST['auctionEndTime']) ? mysqli_real_escape_string($conn, $_POST['auctionEndTime']): null;
    $product_image = $_FILES['image']['name'];
    $product_image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = './../image/' . $product_image;
    $image_size = $_FILES['image']['size'];

    // Handle image upload
    if ($image_size > 0) {
        if ($image_size > 2000000) {
            $message[] = 'Image size is too large, please choose a smaller image.';
        } else {
            if (!move_uploaded_file($product_image_tmp_name, $image_folder)) {
                $message[] = 'Failed to upload the image.';
            }
        }
    } else {
        $product_image = $_POST['old_image']; // Use old image if no new one is uploaded
    }

    // Update product details
    $update_query = "UPDATE products SET 
                 product_name = '$product_name', 
                 product_actual_price = '$product_price', 
                 product_detail = '$product_detail', 
                 product_image = '$product_image',
                 product_category = '$product_category',
                 is_featured = '$is_featured', 
                 auction_date = '$auction_date',
                 auction_end_time = " . ($auction_end_time ? "'$auction_end_time'" : "NULL") . "
                 WHERE product_id = '$update_id'";


    $update_result = mysqli_query($conn, $update_query);

    if ($update_result) {
        $message[] = 'Product updated successfully.';
        header("Location: profile.php");
        exit();
    } else {
        $message[] = 'Failed to update the product.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="./assets/css/user_style.css">
    <link rel="stylesheet" href="./assets/css/user.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>

<body>
    <?php if (isset($_GET['edit'])) { ?>
        <section class="update-container">
            <?php
            $edit_id = $_GET['edit'];
            $edit_query = mysqli_query($conn, "SELECT * FROM `products` WHERE product_id = '$edit_id'") or die('Query failed');

            if (mysqli_num_rows($edit_query) > 0) {
                while ($fetch_edit = mysqli_fetch_assoc($edit_query)) {
            ?>
                    <div class="product">
                        <div class="product-header">Edit Product</div>
                        <section class="product-form-edit">
                            <form method="POST" enctype="multipart/form-data">
                                <!-- Product Image -->
                                <img src="./../image/<?php echo htmlspecialchars($fetch_edit['product_image']); ?>"
                                    alt="Product Image"
                                    style="width: 150px; height: auto; border-radius: 8px; margin-bottom: 1rem;">

                                <input type="hidden" name="update_id" value="<?php echo htmlspecialchars($fetch_edit['product_id']); ?>">
                                <input type="hidden" name="old_image" value="<?php echo htmlspecialchars($fetch_edit['product_image']); ?>">

                                <!-- Product Name -->
                                <label for="updateName">Product Name:</label>
                                <input type="text" id="updateName" name="name"
                                    value="<?php echo htmlspecialchars($fetch_edit['product_name']); ?>" required>

                                <!-- Product Price -->
                                <label for="updatePrice">Product Price:</label>
                                <input type="text" id="updatePrice" name="price" min="0"
                                    value="<?php echo htmlspecialchars($fetch_edit['product_actual_price']); ?>" required>

                                <!-- Product Details -->
                                <label for="updateDetails">Product Details:</label>
                                <textarea id="updateDetails" name="product_detail" rows="5" required><?php echo htmlspecialchars($fetch_edit['product_detail']); ?></textarea>

                                <!-- Product Image Upload -->
                                <label for="updateImage">Product Image:</label>
                                <input type="file" id="updateImage" name="image" accept="image/jpg, image/jpeg, image/png, image/webp">

                                <!-- Category -->
                                <label for="productCategory1">Category:</label>
                                <select id="productCategory1" name="product_category" required>
                                    <option value="fine_arts" <?php echo ($fetch_edit['product_category'] === 'fine_arts') ? 'selected' : ''; ?>>Fine Arts</option>
                                    <option value="jewellery" <?php echo ($fetch_edit['product_category'] === 'jewellery') ? 'selected' : ''; ?>>Jewellery</option>
                                    <option value="collectables" <?php echo ($fetch_edit['product_category'] === 'collectables') ? 'selected' : ''; ?>>Collectables</option>
                                    <option value="decorative_arts" <?php echo ($fetch_edit['product_category'] === 'decorative_arts') ? 'selected' : ''; ?>>Decorative Arts</option>
                                </select>

                                <!-- Auction Type -->
                                <label for="auctionType1">Auction Type:</label>
                                <select id="auctionType1" name="auctionType" required onchange="toggleAuctionDate()">
                                    <option value="featured" <?php echo ($fetch_edit['is_featured'] == 1) ? 'selected' : ''; ?>>Featured</option>
                                    <option value="upcoming" <?php echo ($fetch_edit['auction_date'] !== null) ? 'selected' : ''; ?>>Upcoming</option>
                                </select>

                                <!-- Auction Date -->
                                <div id="upcomingDateContainer" style="<?php echo ($fetch_edit['auction_date'] !== null) ? 'display: block;' : 'display: none;'; ?>">
                                    <label for="auctionDate">Auction Date:</label>
                                    <input type="date" id="auctionDate" name="auctionDate" value="<?php echo htmlspecialchars($fetch_edit['auction_date']); ?>">
                                </div>

                                
                                    <label for="auctionEndTime">Auction End Date:</label>
                                    <input type="datetime-local" id="auctionEndTime" name="auctionEndTime" value="<?php echo htmlspecialchars($fetch_edit['auction_end_time']); ?>">
                                

                                <!-- Submit -->
                                <input type="submit" name="update_product" value="Update" class="edit">
                                <button type="button" class="cancel-btn" onclick="window.location.href='profile.php' ;">Cancel</button>
                            </form>
                        </section>
                    </div>
            <?php
                }
            }
            ?>
        </section>
    <?php } ?>
</body>
<script src="./assets/js/main.js"> </script>

</html>