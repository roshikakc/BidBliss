<?php
include_once 'include/user_header.php';
include './../database.php';

// Fetch featured products
$featured_query = "SELECT * FROM products WHERE is_featured = 1";
$featured_result = mysqli_query($conn, $featured_query);

// Fetch upcoming products (products with future auction dates)
$upcoming_query = "SELECT * FROM products WHERE auction_date > CURDATE()";
$upcoming_result = mysqli_query($conn, $upcoming_query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home page</title>
  <link rel="stylesheet" href="./assets/css/user_style.css">
  <link rel="stylesheet" href="./assets/css/user.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>

<body>
  <section class="hero">
    <div class="background" id="background"></div>
    <div class="content">
      <h1>Lets start the shopping</h1>
      <h2>Lorem ipsum dolor sit amet consectetur adipisici</h2>
      <div>
        <button type="button">Lets Go!!</button>
      </div>
    </div>
  </section>

  <section class="course">
    <h1> Online Bidding Platform </h1>
    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sint nulla quis consequuntur commodi culpa enim quos
      deserunt <br> incidunt praesentium quisquam rerum,
      iusto sit nostrum autem sunt odio blanditiis officiis laboriosam!</p>
  </section>


  <section id="upcomming" class="section-m1">
    <h1>Upcoming Auctions</h1>

    <div class="wrapper">
      <?php
      if (mysqli_num_rows($upcoming_result) > 0) {
        while ($upcoming_product = mysqli_fetch_assoc($upcoming_result)) {
      ?>
          <div class="single-card">
            <div class="img-area">
              <img src="./../image/<?php echo htmlspecialchars($upcoming_product['product_image']); ?>" alt="Product Image">
              <div class="overlay">
                <form action="cart.php" method="post" class="add-to-cart-form">
                  <input type="hidden" name="product_id" value="<?php echo $upcoming_product['product_id']; ?>">
                  <button type="submit" name="add_to_cart" class="add-to-cart">Add to Cart</button>
                </form>

                <a href="product_details.php?product_id=<?php echo $upcoming_product['product_id']; ?>">
                  <button class="view-details">View Details</button>
                </a>
              </div>
            </div>

            <div class="info">
              <h3><?php echo htmlspecialchars($upcoming_product['product_name']); ?></h3>
              <p>Category: <?php echo htmlspecialchars($upcoming_product['product_category']); ?></p> <!-- Display category -->
              <p><?php echo htmlspecialchars($upcoming_product['product_detail']); ?></p>
              <p>Auction Date: <?php echo htmlspecialchars(date('Y-m-d', strtotime($upcoming_product['auction_date']))); ?></p>
            </div>
          </div>
      <?php
        }
      } else {
        echo '<p>No upcoming auctions at the moment.</p>';
      }
      ?>

    </div>
    <button class="view">View more</button>
  </section>



  <section id="featured" class="section-m1">
    <h1> Featured Auctions </h1>

    <div class="wrapper">
      <?php
      if (mysqli_num_rows($featured_result) > 0) {
        while ($featured_product = mysqli_fetch_assoc($featured_result)) {
      ?>

          <div class="single-card">
            <div class="img-area">
              <img src="./../image/<?php echo htmlspecialchars($featured_product['product_image']); ?>" alt="Product Image">
              <div class="overlay">

                <form action="cart.php" method="post" class="add-to-cart-form">
                  <input type="hidden" name="product_id" value="<?php echo $featured_product['product_id']; ?>">
                  <button type="submit" name="add_to_cart" class="add-to-cart">Add to Cart</button>
                </form>

                <a href="product_details.php?product_id=<?php echo $featured_product['product_id']; ?>">
                  <button class="view-details">View Details</button>
                </a>


              </div>
            </div>

            <div class="info">
              <h3><?php echo htmlspecialchars($featured_product['product_name']); ?></h3>
              <p>Category: <?php echo htmlspecialchars($featured_product['product_category']); ?></p> <!-- Display category -->
              <p><?php echo htmlspecialchars($featured_product['product_detail']); ?></p>
            </div>
          </div>
          </form>

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


      <?php
        }
      } else {
        echo '<p>No featured products available.</p>';
      }
      ?>
    </div>
    <button class="view">View more</button>
  </section>


  <section id="hero-section" class="section-p1">
    <div class="section-content">
      <div class="hero-image-wrapper">
        <img src="./../assets/Image/side bg.jpg" alt="mloo">
      </div>
      <div class="hero-details">
        <h1>New to Live and Online Auctions? </h1>
        <h2> Learn how to bid in live auctions.</h2>

        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Magni illo fugit est fuga. Assumenda, autem cumque!
          Consequuntur veritatis, necessitatibus pariatur<br>
          cumque voluptates eaque. Unde totam, laudantium facere magnam voluptatem velit.</p>
      </div>
    </div>
  </section>

  <button class="floating-cart-btn" onclick="window.location.href='cart.php'">
    <i class="fas fa-shopping-cart"></i>
  </button>


</body>
<script src="./assets/js/main.js"> </script>


</html>

<?php
include_once 'include/footer.php';
?>