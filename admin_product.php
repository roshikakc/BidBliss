<?php
include_once './Include/admin_header.php';

include 'database.php';
// session_start();
$admin_id = $_SESSION['admin_name'];

if (!isset($admin_id)) {
    header('location:ad-login.php');
    exit;
}

if (isset($_POST['logout'])) {
    session_destroy();
    header('location:ad-login.php');
    exit;
}
// adding product
if (isset($_POST['add_product'])) {
    $product_name = mysqli_real_escape_string($conn, $_POST['productName']);
    $product_price = mysqli_real_escape_string($conn, $_POST['startingPrice']);
    $product_detail = mysqli_real_escape_string($conn, $_POST['productDetails']);
    $auction_type = $_POST['auctionType'];
    $productCategory = mysqli_real_escape_string($conn, $_POST['productCategory']);
    $auctionEndTime = mysqli_real_escape_string($conn, $_POST['auctionEndTime']);



    $auction_date = null;
    $is_featured = 0; // Default value for non-featured

    if ($auction_type == 'upcoming') {
        $auction_date = mysqli_real_escape_string($conn, $_POST['auctionDate']);
    } elseif ($auction_type == 'featured') {
        $is_featured = 1; // Set as featured if selected
    }

    $product_image = $_FILES['productImage']['name'];
    $product_image_tmp_name = $_FILES['productImage']['tmp_name'];
    $image_folder = './image/' . $product_image;
    $image_size = $_FILES['productImage']['size'];

    $select_product_name = mysqli_query($conn, "SELECT product_name FROM products WHERE product_name = '$product_name'") or die('query failed');

    if (mysqli_num_rows($select_product_name) > 0) {
        $message[] = 'Product name already exists';
    } else {
        $insert_product = mysqli_query($conn, "INSERT INTO products(product_name, product_actual_price, product_detail, product_image, auction_date, is_featured, product_category) 
            VALUES ('$product_name', '$product_price', '$product_detail', '$product_image', '$auction_date', $is_featured, '$productCategory')") or die('query failed');

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
    header('location:admin_product.php');
}

//update products
if (isset($_POST['update_product'])) {
    $update_id = $_POST['update_id'];
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $details = mysqli_real_escape_string($conn, $_POST['product_detail']);
    $image = $_FILES['image']['name'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = 'image/' . $image;

    if (!empty($image)) {
        move_uploaded_file($image_tmp_name, $image_folder);
        mysqli_query($conn, "UPDATE `products` SET name='$name', price='$price', product_detail='$details', image='$image' WHERE id='$update_id'") or die('Query failed');
    } else {
        mysqli_query($conn, "UPDATE `products` SET name='$name', price='$price', product_detail='$details' WHERE id='$update_id'") or die('Query failed');
    }

    header('location:admin_product.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/admin.css">
    <link rel="stylesheet" href="./assets/css/style.css">
    <title>Product</title>
</head>

<body>
    <?php
    if (isset($message)) {
        foreach ($message as $message) {
            echo '
            <div class="message1">
                <span>' . $message . ' </span>
                <i class="fa-regular fa-circle-xmark" onclick="this.parentElement.remove()"></i>
            </div>
            ';
        }
    }
    ?>

    <?php if (!isset($_GET['edit'])) { ?>
        <!-- Product Form -->
        <div class="dynamic-content home">
            <div class="product-header">Product</div>

            <div class="tab-content" id="products">
                <!-- product list -->
                <section class="product-list">
                    <?php
                    // Fetch products along with the user's name
                    $select_products = mysqli_query($conn, "SELECT p.*, u.user_name FROM products p LEFT JOIN user u ON p.user_id = u.user_id") or die('query failed');
                    if (mysqli_num_rows($select_products) > 0) {
                        while ($fetch_products = mysqli_fetch_assoc($select_products)) {
                    ?>
                            <div class="single-card" style="height:500px;">
                                <div class="img-area">
                                    <img src="./image/<?php echo htmlspecialchars($fetch_products['product_image']); ?>" alt="Product Image">
                                </div>
                                <div class="info">
                                    <h3><?php echo htmlspecialchars($fetch_products['product_name']); ?></h3>
                                    <p>Starting Price: RS <?php echo htmlspecialchars($fetch_products['product_actual_price']); ?></p>
                                    <p><?php echo htmlspecialchars($fetch_products['product_detail']); ?></p>
                                    <p>Auction Ends On: <?php echo htmlspecialchars($fetch_products['auction_end_time']); ?></p>
                                    <p>Added By: <?php echo htmlspecialchars($fetch_products['user_name']); ?></p> <!-- Displaying the user who added the product -->

                                    <a href="profile.php?delete=<?php echo $fetch_products['product_id']; ?>" class="delete" onclick="return confirm('Want to delete this product?');">Delete</a>
                                </div>
                            </div>
                    <?php
                        }
                    } else {
                        echo ' <div class="empty"><p>No products added yet!</p></div>';
                    }

                    ?>

                </section>
            </div>
        </div>
    <?php } ?>
    </div>


    <script>
        // auction date
        document.addEventListener('DOMContentLoaded', function() {
            // Get the elements by their IDs
            const auctionTypeSelect = document.getElementById('auctionType');
            const upcomingDateContainer = document.getElementById('upcomingDateContainer');

            // Function to handle the dropdown change
            auctionTypeSelect.addEventListener('change', function() {
                // If 'upcoming' is selected, show the date input
                if (auctionTypeSelect.value === 'upcoming') {
                    upcomingDateContainer.style.display = 'block';
                } else {
                    upcomingDateContainer.style.display = 'none';
                }
            });

            // Initial check on page load to hide/show the date input
            if (auctionTypeSelect.value === 'upcoming') {
                upcomingDateContainer.style.display = 'block';
            } else {
                upcomingDateContainer.style.display = 'none';
            }
        });
    </script>
    <script src="./assets/js/script.js"></script>
</body>

</html>