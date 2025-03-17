<?php
include_once 'include/user_header.php';
include './../database.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if product_id is passed
if (isset($_GET['product_id'])) {
    $product_id = intval($_GET['product_id']); // Sanitize input

    // Fetch product details from the database
    $sql = "SELECT product_name, product_image, product_actual_price, product_latest_price, product_detail, auction_date, auction_end_time, is_featured FROM products WHERE product_id = $product_id";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);
        $product_name = $product['product_name'];
        $product_image = $product['product_image'];
        $product_actual_price = $product['product_actual_price'];
        $product_latest_price = $product['product_latest_price'];
        $product_detail = $product['product_detail'];
        $auction_date = $product['auction_date'];
        $auction_end_time = $product['auction_end_time'] ?? null;


        // If auction_end_time is still NULL, show an error or set a default message
        if (empty($auction_end_time)) {
            $auction_end_time = "Not specified"; // Don't overwrite, just set a display message
        }

        // Insert the new product into the database
        $sql = "INSERT INTO products (product_name, product_image, product_actual_price, product_detail, auction_date, auction_end_time)
        VALUES ('$product_name', '$product_image', '$product_actual_price', '$product_detail', '$auction_date', '$auction_end_time')";

        if (!empty($auction_date)) {
            $is_upcoming = strtotime($auction_date) > time();
        } else {
            $is_upcoming = false;
            $auction_date = "Auction date not available";
        }
        // Set PHP timezone to match MySQL timezone
        date_default_timezone_set('Asia/Kathmandu'); // Change this based on your MySQL timezone

        $current_time = date('Y-m-d H:i:s');
        $is_auction_ended = false;

        // Ensure auction_end_time exists and is not NULL
        if (!empty($auction_end_time) && strtotime($auction_end_time) <= strtotime($current_time)) {
            $is_auction_ended = true;
        }

        // Fetch auction type from database
        $sql = "SELECT product_name, product_image, product_actual_price, product_latest_price, product_detail, auction_date, auction_end_time, is_featured FROM products WHERE product_id = $product_id";
        $result = mysqli_query($conn, $sql);
        // Featured auctions do not end automatically
        // if ($is_featured == 1){
        //     $is_auction_ended = false;
        // }





        // Get highest bidder
        $highest_bidder_query = mysqli_query($conn, "SELECT user_id FROM bids WHERE product_id = $product_id ORDER BY bid_amount DESC LIMIT 1");
        $highest_bidder = mysqli_fetch_assoc($highest_bidder_query)['user_id'] ?? null;
    } else {
        echo "Product not found.";
        exit;
    }

    // Handle the bid submission
    if (isset($_POST['place_bid'])) {
        $bid_amount = intval($_POST['bid_amount']);

        // Check if bid amount is valid
        $minimum_bid = max($product_actual_price, $product_latest_price) + 1000;
        if ($bid_amount >= $minimum_bid) {
            // Insert the bid into the bids table
            $user_id = $_SESSION['user_id'];
            $bid_sql = "INSERT INTO bids (user_id, product_id, bid_amount) VALUES ('$user_id', '$product_id', '$bid_amount')";
            if (mysqli_query($conn, $bid_sql)) {
                // Update the latest price in the database
                $update_sql = "UPDATE products SET product_latest_price = $bid_amount WHERE product_id = $product_id";
                mysqli_query($conn, $update_sql);
                echo "<script>
                             Swal.fire({
  title: 'Success!',
  text: 'Bid has been placed!',
  icon: 'success',
showConfirmButton: false,
  timer: 1500
  })
                setTimeout(()=>{
 
                window.location.href='?product_id=$product_id';
  },2000);  

               </script>";
            } else {
                echo "Error updating bid: " . mysqli_error($conn);
            }
        } else {
            echo "<script>alert('Bid must be at least Rs. 1000 more than the current price.');</script>";
        }
    }
} else {
    echo "Invalid product ID.";
    exit;
}
// Fetch all bids for the product
$starting_price = $product_actual_price;
$current_price = $product_latest_price;

$bid_history = [];
$increment = 1000; // Minimum increment

// Generate bid history from starting price to latest price
while ($starting_price < $current_price) {
    $starting_price += $increment;
    $bid_history[] = $starting_price;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bidding Page</title>
    <link rel="stylesheet" href="./assets/css/user_style.css">
    <link rel="stylesheet" href="./assets/css/user.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>

<body>
    <div class="main-content">
        <h1><?php echo htmlspecialchars($product_name); ?></h1>
        <div class="bidding-container">
            <div class="image-section">
                <img src="./../image/<?php echo htmlspecialchars($product_image); ?>" alt="Product Image" />
            </div>
            <div class="info-section">
                <div class="starting-bid">
                    <h1>Current Price: </h1>
                    <h2>Rs<?php echo htmlspecialchars(max($product_actual_price, $product_latest_price)); ?></h2>
                    <?php if ($is_upcoming): ?>
                        <p>Auction starts on: <strong><?php echo htmlspecialchars($auction_date); ?></strong></p>
                        <input type="number" id="bid-input" placeholder="Enter bid amount" disabled />
                        <button class="bid-button" disabled>Bid</button>
                    <?php elseif ($is_auction_ended): ?>
                        <p style="color: red; font-size: 18px;"><strong>Auction Ended</strong></p>

                        <!-- <script>
                            document.getElementById('bid-input').disabled = true;
                            document.querySelector('.bid-button').disabled = true;
                        </script> -->

                        <?php if ($_SESSION['user_id'] == $highest_bidder): ?>

                            <form action="checkout.php" method="GET">
                                <input type="hidden" name="product_id" value="<?php echo isset($product_id) ? $product_id : 0; ?>">
                                <p>Congratulations you have won the item!</p>
                                <button type="submit" style="background-color: #4CAF50; color: white;">Checkout</button>
                            </form>

                        <?php else: ?>
                            <p>The auction has ended.</p>
                        <?php endif; ?>

                    <?php else: ?>
                        <!-- Auction is ongoing, allow bidding -->
                        <p>Auction Ends On: <strong><?php echo htmlspecialchars($auction_end_time); ?></strong></p>
                        <p><strong>Starting Bid:</strong> Rs <?php echo htmlspecialchars($product_actual_price); ?></p>
                        <div class="bid-section">
                            <form action="" method="post">
                                <input type="number" id="bid-input" name="bid_amount" placeholder="Enter bid amount"
                                    min="<?php echo max($product_actual_price, $product_latest_price) + 1000; ?>"
                                    step="1000" required />
                                <button type="submit" name="place_bid" class="bid-button">Place Bid</button>
                            </form>
                        </div>
                    <?php endif; ?>
                </div>
                <!-- <div class="dropdown-container">
                    <label>Bid Increment History</label>
                    <div class="dropdown">
                        <button class="dropdown-toggle" onclick="toggleDropdown()">View History</button>
                        <div class="dropdown-content" id="bid-history" style="display: none;">
                            <?php if (!empty($bid_history)): ?>
                                <?php foreach ($bid_history as $bid): ?>
                                    <p>Rs <?php echo htmlspecialchars($bid); ?></p>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p>No bids placed yet.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div> -->


                <div class="additional-actions">
                    <form action="cart.php" method="post" class="action-form">
                        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                        <input type="hidden" name="add_to_cart" value="1">
                        <button type="submit" class="watch-list">Add to cart</button>
                    </form>
                    <button class="register" onclick="window.location.href='./../register.php'">Register to bid</button>
                </div>
            </div>
        </div>
        <div class="description-section">
            <h1>Description</h1>
            <p><?php echo htmlspecialchars($product_detail); ?></p>
        </div>
    </div>
    <script>
        function toggleDropdown() {
            var historyDropdown = document.getElementById("bid-history");
            if (historyDropdown.style.display === "none") {
                historyDropdown.style.display = "block";
            } else {
                historyDropdown.style.display = "none";
            }
        }
    </script>


</body>

</html>
<script src="./assets/js/main.js"></script>
<?php
include_once 'include/footer.php';
?>