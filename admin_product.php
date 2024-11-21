<?php
include_once './Include/admin_header.php';

include 'database.php';
// session_start();
$admin_id =$_SESSION['admin_name'];

 if (!isset($admin_id)) {
    header('location:login.php');
    exit;
}

if (isset($_POST['logout'])) {
    session_destroy();
    header('location:login.php');
  exit;
}
//adding products in database
if( isset($_POST['add_product'])) {
    $product_name = mysqli_real_escape_string($conn, $_POST['productName']);
    $product_price = mysqli_real_escape_string($conn, $_POST['startingPrice']);
    $product_detail = mysqli_real_escape_string($conn, $_POST['productDetails']);

    $product_image = $_FILES['productImage']['name'];
    $product_image_tmp_name = $_FILES['productImage']['tmp_name'];
    $image_folder = 'image/' . $product_image;
    $image_size = $_FILES['productImage']['size'];


    $select_product_name = mysqli_query($conn, "SELECT name FROM `products` WHERE name = '$product_name'") or die(
        'query failed');
        if(mysqli_num_rows($select_product_name)>0){
            $message[] ='product name already exist';
        }else{
            $insert_product = mysqli_query($conn, "INSERT INTO `products`(`name`, `price`,`product_detail`, `image`)
            VALUES('$product_name','$product_price', '$product_detail','$product_image')") or die('quer failed');
            if($insert_product){
                if($image_size >2000000){
                    $message[]= 'image size too large';
                }
                else{
                   if(move_uploaded_file($product_image_tmp_name, $image_folder)){
                    $message[] = 'product added successfully';
                } else{
                    $message[] = 'Failed to upload image';
                }
            }
          }else{
            $message[] = 'Failed to add product';
          }
        }
}


//delete products from database
if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    $select_delete_image = mysqli_query($conn,"DELETE FROM `products` WHERE id = '$delete_id'") or die ('query failed');
    $select_delete_image = mysqli_query($conn,"DELETE FROM `cart` WHERE pid = '$delete_id'") or die ('query failed');
    $select_delete_image = mysqli_query($conn,"DELETE FROM `wishlist` WHERE pid = '$delete_id'") or die ('query failed');

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
        <div class="product">
            <div class="product-header">Product</div>
            <div class="products-section">
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

                        <button type="submit" name="add_product">Add Product</button>
                    </form>
                </section>

                <!-- Product List -->
                <section class="product-list">
                    <?php
                    $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
                    if (mysqli_num_rows($select_products) > 0) {
                        while ($fetch_products = mysqli_fetch_assoc($select_products)) {
                    ?>
                    <!-- product card -->
                            <div class="product-card">
                                <img src="image/<?php echo $fetch_products['image']; ?>" alt="Product Image">
                                <p><?php echo htmlspecialchars($fetch_products['name']); ?></p>
                                <p>Starting Price: RS<?php echo htmlspecialchars($fetch_products['price']); ?></p>
                                <details><?php echo $fetch_products['product_detail'];?> </details>
                                <a href="admin_product.php?edit=<?php echo $fetch_products['id']; ?>" class="edit">Edit</a>
                                <a href="admin_product.php?delete=<?php echo $fetch_products['id']; ?>" class="delete" onclick="return confirm('Want to delete this product?');">Delete</a>
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
        </div>
    <?php } ?>

    <!-- for edit -->
    <?php if (isset($_GET['edit'])) { ?>
        <section class="update-container">
            <?php
            $edit_id = $_GET['edit'];
            $edit_query = mysqli_query($conn, "SELECT * FROM `products` WHERE id = '$edit_id'") or die('Query failed');

            if (mysqli_num_rows($edit_query) > 0) {
                while ($fetch_edit = mysqli_fetch_assoc($edit_query)) {
            ?>
                    <div class="product">
                        <div class="product-header">Edit Product</div>
                        <section class="product-form-edit">
                            <form method="POST" enctype="multipart/form-data">
                                <img src="image/<?php echo $fetch_edit['image']; ?>" alt="Product Image" style="width: 150px; height: auto; border-radius: 8px; margin-bottom: 1rem;">

                                <input type="hidden" name="update_id" value="<?php echo $fetch_edit['id']; ?>">

                                <label for="updateName">Product Name:</label>
                                <input type="text" id="updateName" name="name" value="<?php echo $fetch_edit['name']; ?>" required>

                                <label for="updatePrice">Product Price:</label>
                                <input type="text" id="updatePrice" name="price" min="0" value="<?php echo $fetch_edit['price']; ?>" required>

                                <label for="updateDetails">Product Details:</label>
                                <textarea id="updateDetails" name="product_detail" rows="5" required><?php echo $fetch_edit['product_detail']; ?></textarea>

                                <label for="updateImage">Product Image:</label>
                                <input type="file" id="updateImage" name="image" accept="image/jpg, image/jpeg, image/png, image/webp">

                                <input type="submit" name="update_product" value="Update" class="edit">
                                <button type="button" class="cancel-btn" onclick="window.location.href='admin_product.php';">Cancel</button>
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

</html>
