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

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="./assets/css/admin.css">
    <title>Home</title>
</head>
<body>
<div class="home">
        <div class="home-header">Home</div>
    <section class="info-cards">
        <div class="card">
            <?php
            $total_pending =0;
            $select_pendings = mysqli_query($conn, "SELECT * FROM `order` WHERE payment_status = 'pending' ")
            or die('query failed');
            while ($fetch_pending = mysqli_fetch_assoc($select_pendings)){
                $total_pending +=$fetch_pending['total_price'];
            }
            ?>
            <h3>Rs <?php echo $total_pending;?>/-</h3>
            <br><p>total pending</p>
            </div>

        <div class="card">
            <?php
            $total_completed =0;
            $select_completed = mysqli_query($conn, "SELECT * FROM `order` WHERE payment_status = 'complete' ")
            or die('query failed');
            while ($fetch_completed = mysqli_fetch_assoc($select_completed)){
                $total_completed +=$fetch_completed['total_price'];
            }
            ?>
            <h3>Rs <?php echo $total_completed;?>/-</h3>
            <br><p>total completed</p>
            </div>

        <div class="card">
            <?php
            $select_order = mysqli_query($conn, "SELECT * FROM `order`")
            or die('query failed');
            $num_of_order = mysqli_num_rows($select_order);
            ?>
            <h3><?php echo $num_of_order;?></h3>
            <br><p>order placed</p>
            </div>

            
        <div class="card">
            <?php
            $select_product = mysqli_query($conn, "SELECT * FROM `order`")
            or die('query failed');
            $num_of_product = mysqli_num_rows($select_product);
            ?>
            <h3><?php echo $num_of_product;?></h3>
            <br><p>product added</p>
            </div>


        <div class="card">
            <?php
            $select_message = mysqli_query($conn, "SELECT * FROM `message`")
            or die('query failed');
            $num_of_message = mysqli_num_rows($select_message);
            ?>
            <h3><?php echo $num_of_message;?></h3>
            <br><p>new messages</p>
            </div>

        

    </div>
    </section>

</body>
</html>
 