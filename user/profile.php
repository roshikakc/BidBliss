<?php
include_once 'include/user_header.php';
include './../database.php';


// Fetch user data from the database
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $query = "SELECT * FROM `user` WHERE `user_id` = '$user_id'";
    $result = mysqli_query($conn, $query);
    $user_data = mysqli_fetch_assoc($result);
} else {
    header("Location: ad-login.php");
    exit;
}

// adding product
if (isset($_POST['add_product'])) {
    // var_dump($_POST);
    $product_name = mysqli_real_escape_string($conn, $_POST['productName']);
    $product_price = mysqli_real_escape_string($conn, $_POST['startingPrice']);
    $product_detail = mysqli_real_escape_string($conn, $_POST['productDetails']);
    $auction_type = $_POST['auctionType'];
    $productCategory = mysqli_real_escape_string($conn, $_POST['productCategory']);
    $auction_end_time = date('Y-m-d H:i:s', strtotime($_POST['auctionEndTime']));


    // Get the user_id from the session
    $product_user_id = $_SESSION['user_id'];
    $is_featured = ($auction_type == 'featured') ? 1 : 0;

    // Set auction date to NULL if empty
    $auction_date = !empty($_POST['auctionDate']) ? "'" . mysqli_real_escape_string($conn, $_POST['auctionDate']) . "'" : "NULL";

    // $auction_date = null;
    // $is_featured = 0; // Default value for non-featured

    // if ($auction_type == 'upcoming') {
    //     $auction_date = mysqli_real_escape_string($conn, $_POST['auctionDate']);
    // } elseif ($auction_type == 'featured') {
    //     $is_featured = 1; // Set as featured if selected
    // }

    $product_image = $_FILES['productImage']['name'];
    $product_image_tmp_name = $_FILES['productImage']['tmp_name'];
    $image_folder = './../image/' . $product_image;
    $image_size = $_FILES['productImage']['size'];

    $select_product_name = mysqli_query($conn, "SELECT product_name FROM products WHERE product_name = '$product_name'") or die('query failed');

    if (mysqli_num_rows($select_product_name) > 0) {
        $message[] = 'Product name already exists';
    } else {
        $auction_date = !empty($_POST['auctionDate']) ? "'" . mysqli_real_escape_string($conn, $_POST['auctionDate']) . "'" : "NULL";

$query = "INSERT INTO products 
    (product_name, product_actual_price, product_detail, product_image, auction_date, is_featured, product_category, user_id, auction_end_time) 
VALUES 
    ('$product_name', '$product_price', '$product_detail', '$product_image', $auction_date, $is_featured, '$productCategory', '$user_id', '$auction_end_time')";

$insert_product = mysqli_query($conn, $query) or die(mysqli_error($conn));


        if ($insert_product) {
            if ($image_size > 2000000) {
                $message[] = 'Image size too large';
            } else {
                if (move_uploaded_file($product_image_tmp_name, $image_folder)) {
                    $message[] = 'Product added successfully';
                } else {
                    $message[] = 'Failed to upload image';
                }
            }
        } else {
            $message[] = 'Failed to add product';
        }
    }
}

// Deleting products from the database
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM products WHERE product_id = '$delete_id'") or die('query failed');
    header('location:profile.php');
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="./assets/css/user_style.css">
    <link rel="stylesheet" href="./assets/css/user.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <style>






    </style>
</head>

<body>
    <div class="profile-container">
        <div class="profile-header">
            <div class="profile-image">
                <img src="./../image/<?php echo htmlspecialchars($user_data['profile_image']); ?>" alt="Profile Image" style="width: 150px; height: 150px;">
            </div>
            <div class="profile-info">
                <h1><?php echo htmlspecialchars($user_data['user_name']); ?></h1>
                <p>Member Since: <?php echo htmlspecialchars(date('Y-m-d', strtotime($user_data['created_at']))); ?></p>
                <p>Location: <?php echo htmlspecialchars($user_data['location'] ?? 'NA'); ?></p>
            </div>
        </div>
        <div class="profile-actions">
            <a href="edit_profile.php" class="btn btn-primary">Edit Profile</a>
            <div class="rating">
                <span>Rating:</span>
                <i class="fa-solid fa-star"></i>
                <span>0.0 (0)</span>
            </div>
        </div>
        <div class="profile-tabs">
            <ul>
                <li class="tab active" data-target="add-products">Add Products</li>
                <li class="tab" data-target="products">Products</li>
                <li class="tab" data-target="analytics">Analytics</li>
            </ul>
        </div>
        <div class="tab-content active" id="add-products">
            <section class="product-form">
                <form action="" method="POST" enctype="multipart/form-data">
                    <label for="productName">Product Name:</label>
                    <input type="text" id="productName" name="productName" required>

                    <label for="startingPrice">Product Starting Price:</label>
                    <input type="text" id="startingPrice" name="startingPrice" required>

                    <label for="productDetails">Product Details and Certificate:</label>
                    <textarea id="productDetails" name="productDetails" required></textarea>

                    <label for="productImage">Product Image:</label>
                    <input type="file" id="productImage" name="productImage" required>

                    <label for="productCategory" style="width: 20%;">Category:</label>
                    <select id="productCategory" name="productCategory" required>
                        <option value="fine_arts">Fine Arts</option>
                        <option value="jewellery">Jewellery</option>
                        <option value="collectables">Collectables</option>
                        <option value="decorative_arts">Decorative Arts</option>
                    </select>

                    <label for="auctionType" style="width: 20%;">Auction Type:</label>
                    <select id="auctionType" name="auctionType" required>
                        <option value="featured">Featured</option>
                        <option value="upcoming">Upcoming</option>
                    </select>

                    <!-- Date Picker for Upcoming Auctions (hidden by default) -->
                    <div id="upcomingDateContainer" style="display: none;">
                        <label for="auctionDate">Auction Date:</label>
                        <input type="date" id="auctionDate" name="auctionDate">
                    </div>

                    <label for="auctionEndTime">Auction End Time:</label>
                    <input type="datetime-local" id="auctionEndTime" name="auctionEndTime" required>

                    <button type="submit" name="add_product">Add Product</button>
                </form>
            </section>

        </div>

        <div class="tab-content" id="products">
            <h2>Products</h2>
            <section class="product-list">
                <?php
                $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
                if (mysqli_num_rows($select_products) > 0) {
                    while ($fetch_products = mysqli_fetch_assoc($select_products)) {
                ?>
                        <div class="single-card" style="height:500px;">
                            <div class="img-area">
                                <img src="./../image/<?php echo $fetch_products['product_image']; ?>" alt="Product Image">

                            </div>
                            <div class="info">
                                <h3><?php echo htmlspecialchars($fetch_products['product_name']); ?></h3>
                                <p>Starting Price: RS <?php echo htmlspecialchars($fetch_products['product_actual_price']); ?></p>
                                <p><?php echo htmlspecialchars($fetch_products['product_detail']); ?></p>
                                <p>Auction Ends On: <?php echo date('d M Y h:i A', strtotime($fetch_products['auction_end_time'])); ?></p>


                                <a href="product_edit.php?edit=<?php echo $fetch_products['product_id']; ?>" class="edit">Edit</a>

                                <a href="profile.php?delete=<?php echo $fetch_products['product_id']; ?>" class="delete" onclick="return confirm('Want to delete this product?');">Delete</a>
                            </div>

                        </div>
                <?php
                    }
                } else {
                    echo '
            <div class="empty">
                <p>No products added yet!</p>
            </div>
            ';
                }
                ?>

            </section>
        </div>
        <div class="tab-content" id="analytics">
            <h2>Orders</h2>

            <table>
                <tr>
                    <th>Order ID</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Customer Name</th>
                    <th>Customer Address</th>
                    <th>Customer Phone</th>
                    <th>Status</th>
                </tr>

                <?php
                // Fetch orders that belong to the current seller
                $seller_id = $_SESSION['user_id'];
                $query = "
            SELECT o.order_id, p.product_name, p.product_latest_price, o.customer_name, o.customer_address, o.customer_phone, o.status
            FROM orders o
            JOIN products p ON o.product_id = p.product_id
            WHERE p.user_id = '$seller_id'
        ";
                $order_result = mysqli_query($conn, $query);

                if (mysqli_num_rows($order_result) > 0) {
                    while ($order = mysqli_fetch_assoc($order_result)) {
                        echo "<tr>
                    <td>{$order['order_id']}</td>
                    <td>{$order['product_name']}</td>
                    <td>Rs {$order['product_latest_price']}</td>
                    <td>{$order['customer_name']}</td>
                    <td>{$order['customer_address']}</td>
                    <td>{$order['customer_phone']}</td>
                    <td>{$order['status']}</td>
                </tr>";
                    }
                } else {
                    echo '
            <tr>
                <td colspan="7">No orders found for your products.</td>
            </tr>';
                }
                ?>
            </table>


        </div>
       
</body>
<script src="./assets/js/main.js"> </script>

</html>