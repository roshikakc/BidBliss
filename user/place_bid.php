<!-- <?php
// include './../database.php';

// header('Content-Type: application/json'); // Ensure response is JSON

// if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['product_id']) && isset($_POST['bid_amount'])) {
//     $product_id = intval($_POST['product_id']);
//     $bid_amount = intval($_POST['bid_amount']);

//     // Fetch current latest price
//     $query = "SELECT product_latest_price FROM products WHERE product_id = $product_id";
//     $result = mysqli_query($conn, $query);
//     $row = mysqli_fetch_assoc($result);
//     $current_price = $row['product_latest_price'] ?? 0;

//     // Ensure bid is higher than the current price + 1000
//     if ($bid_amount >= ($current_price + 1000)) {
//         $update_sql = "UPDATE products SET product_latest_price = $bid_amount WHERE product_id = $product_id";

//         if (mysqli_query($conn, $update_sql)) {
//             echo json_encode(["success" => true]);
//         } else {
//             echo json_encode(["success" => false, "message" => "Database update failed"]);
//         }
//     } else {
//         echo json_encode(["success" => false, "message" => "Bid must be at least Rs " . ($current_price + 1000)]);
//     }
// } else {
//     echo json_encode(["success" => false, "message" => "Invalid request"]);
// }
?> -->
