<?php
include_once './Include/admin_header.php';

include 'database.php';
// session_start();
$admin_id =$_SESSION['admin_name'];

 if (!isset($admin_id)) {
    header('location:ad-login.php');
    exit;
}

if (isset($_POST['logout'])) {
    session_destroy();
    header('location:ad-login.php');
  exit;
}


//delete products from database

if(isset($_POST['delete_id'])){
    $delete_id = $_POST['delete_id'];
    $deleteSql = mysqli_query($conn,"DELETE FROM `message` WHERE id = '$delete_id'");
    if (mysqli_affected_rows($conn)>0) {
        echo "success";
    } else {
        echo "failed";
    }
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="./assets/css/admin.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
    
    <div class="dynamic-content home">
        <div class="mess-header">Orders</div>
        <div class="table-container">
        <table>
                <tr>
                    <th>Order ID</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Customer Name</th>
                    <th>Customer Address</th>
                    <th>Customer Phone</th>
                    <th>Status</th>
                    <th>Seller Username</th>
                </tr>

                <?php
                // Fetch orders that belong to the current seller
                
                $query = "
                SELECT o.order_id, p.product_name, p.product_latest_price, o.customer_name, 
                       o.customer_address, o.customer_phone, o.status, 
                       u.user_name AS seller_name  
                FROM orders o
                JOIN products p ON o.product_id = p.product_id
                JOIN user u ON p.user_id = u.user_id  -- Ensure this join is included to fetch seller info
            ";
            

            
            $order_result = mysqli_query($conn, $query) or die("Query Failed: " . mysqli_error($conn));

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
                    <td>" .( isset($order['seller_name']) ? $order['seller_name'] : 'N/A') . "</td>

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
    </div>

    

<script src="./assets/js/script.js"></script>
</body>

</html>