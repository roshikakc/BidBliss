<?php
include_once 'include/user_header.php';
include './../database.php';

$query = "SELECT * FROM `products` WHERE `product_category` = 'jewellery'";
$result = mysqli_query($conn, $query) or die('Query failed');

// Store products in an array
$jewelleryProducts = [];
if (mysqli_num_rows($result) > 0) {
  while ($row = mysqli_fetch_assoc($result)) {
    $jewelleryProducts[] = $row;
  }
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
</head>

<body>
  <section class="finearts">
    <h1> Jewellery </h1>
    <p> Lorem ipsum dolor sit amet consectetur adipisicing elit. Quaerat a animi quia qui ratione omnis quam porro, minima dolorem explicabo nesciunt quo possimus error debitis obcaecati, blanditiis vitae? Aperiam, sed.
      Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorem rem ullam modi, veritatis asperiores ex repudiandae cumque vitae dolores consequuntur quas molestiae quibusdam ad nostrum et aperiam eaque quis Lorem, ipsum dolor sit amet consectetur adipisicing elit. Aliquid ducimus numquam quisquam. Maiores perspiciatis ipsam eligendi aspernatur doloribus aliquid officiis suscipit. Ea mollitia, aut sunt debitis impedit eius dolores Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsum officiis, alias at dolores ipsam et, provident illum totam nulla sint molestiae dolore beatae? Quia accusamus excepturi ratione. Facere, ea vel.
    </p>
  </section>


  <section id="upcomming" class="section-m1">
    <h1> Upcomming Auctions </h1>

    <div class="wrapper">
      <?php
      foreach ($jewelleryProducts as $product) {
        if (!empty($product['auction_date'])) { // Check if the product has an auction date
      ?>
          <div class="single-card">
            <div class="img-area">
              <img src="./../image/<?php echo htmlspecialchars($product['product_image']); ?>" alt="Product Image">
              <div class="overlay">
                <form action="cart.php" method="post" class="add-to-cart-form">
                  <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                  <button type="submit" name="add_to_cart" class="add-to-cart">Add to Cart</button>
                </form>

                <a href="product_details.php?product_id=<?php echo $product['product_id']; ?>">
                  <button class="view-details">View Details</button>
                </a>
              </div>
            </div>

            <div class="info">
              <h3><?php echo htmlspecialchars($product['product_name']); ?></h3>
              <p>Starting Price: RS <?php echo htmlspecialchars($product['product_actual_price']); ?></p>
              <p><?php echo htmlspecialchars($product['product_detail']); ?></p>
              <p>Auction Date: <?php echo htmlspecialchars($product['auction_date']); ?></p>
            </div>
          </div>
      <?php
        }
      }
      ?>
    </div>
    <button class="view">View more</button>
  </section>


  <section id="featured" class="section-m1">
    <h1> Featured Auctions </h1>

    <div class="wrapper">
      <?php
      foreach ($jewelleryProducts as $product) {
        if ($product['is_featured'] == 1) { // Check if the product is featured
      ?>
          <div class="single-card">
            <div class="img-area">
              <img src="./../image/<?php echo htmlspecialchars($product['product_image']); ?>" alt="Product Image">
              <div class="overlay">
                <form action="cart.php" method="post" class="add-to-cart-form">
                  <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                  <button type="submit" name="add_to_cart" class="add-to-cart">Add to Cart</button>
                </form>

                <a href="product_details.php?product_id=<?php echo $product['product_id']; ?>">
                  <button class="view-details">View Details</button>
                </a>
              </div>
            </div>

            <div class="info">
              <h3><?php echo htmlspecialchars($product['product_name']); ?></h3>
              <p>Starting Price: RS <?php echo htmlspecialchars($product['product_actual_price']); ?></p>
              <p><?php echo htmlspecialchars($product['product_detail']); ?></p>
            </div>
          </div>
      <?php
        }
      }
      ?>
    </div>
    <script>
      $(document).ready(function() {
        // Attach AJAX submission to the specific form
        $('#addToCartForm<?php echo $featured_product['product_id']; ?>').submit(function(e) {
          e.preventDefault(); // Prevent the default form submission (which causes page redirect)

          var formData = $(this).serialize();

          $.ajax({
            type: 'POST',
            url: 'cart.php',
            data: formData,
            success: function(response) {
              alert(response); // Display success message from PHP (e.g., "Product added to cart!")

            },
            error: function() {
              alert('There was an error adding the product to the cart.');
            }
          });
        });
      });
    </script>
    <button class="view">View more</button>
  </section>
  <button class="floating-cart-btn" onclick="window.location.href='cart.php'">
    <i class="fas fa-shopping-cart"></i>
  </button>

</body>

</html>

<?php
include_once 'include/footer.php';
?>