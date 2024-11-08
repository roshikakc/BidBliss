<?php
include 'include/admin_header.php'
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="./assets/css/admin.css">
    <title>Product</title>
</head>
<body>
    <!-- Product Form -->
    <section class="product-form">
            <form action="add_product.php" method="POST" enctype="multipart/form-data">
                <label for="productName">Product Name:</label>
                <input type="text" id="productName" name="productName" required>

                <label for="startingPrice">Product Starting Price:</label>
                <input type="text" id="startingPrice" name="startingPrice" required>

                <label for="productDetails">Product Details and Certificate:</label>
                <textarea id="productDetails" name="productDetails" required></textarea>
                <input type="file" id="productImage" name="productImage" required>
                
                <label for="productImage">Product Image:</label>
                <input type="file" id="productImage" name="productImage" required>

                <button type="submit">Add Product</button>
            </form>
        </section>

        <!-- Product List -->
    <section class="product-list">

        <div class="product-card">
            <img src="./assets/Image/Bell.jpg" alt="Product Image">
            <p>Starting Price: <span>Rs10000</span></p>
            <p>Name: <span>Sample Product</span></p>
            <button>Edit</button>
            <button>Delete</button>
        </div>
        <div class="product-card">
            <img src="./assets/Image/Bell.jpg" alt="Product Image">
            <p>Starting Price: <span>Rs10000</span></p>
            <p>Name: <span>Sample Product</span></p>
            <button>Edit</button>
            <button>Delete</button>
        </div>
        <div class="product-card">
            <img src="./assets/Image/Bell.jpg" alt="Product Image">
            <p>Starting Price: <span>Rs10000</span></p>
            <p>Name: <span>Sample Product</span></p>
            <button>Edit</button>
            <button>Delete</button>
        </div>
        <div class="product-card">
            <img src="./assets/Image/Bell.jpg" alt="Product Image">
            <p>Starting Price: <span>Rs10000</span></p>
            <p>Name: <span>Sample Product</span></p>
            <button>Edit</button>
            <button>Delete</button>
        </div>
        <div class="product-card">
            <img src="./assets/Image/Bell.jpg" alt="Product Image">
            <p>Starting Price: <span>Rs10000</span></p>
            <p>Name: <span>Sample Product</span></p>
            <button>Edit</button>
            <button>Delete</button>
        </div>
        <div class="product-card">
            <img src="./assets/Image/Bell.jpg" alt="Product Image">
            <p>Starting Price: <span>Rs10000</span></p>
            <p>Name: <span>Sample Product</span></p>
            <button>Edit</button>
            <button>Delete</button>
        </div>
     
    </section>

    <?php
    include 'include/footer.php'
    ?>
</body>
</html>