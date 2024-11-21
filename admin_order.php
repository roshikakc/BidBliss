<?php
include_once 'include/admin_header.php';

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
    
    <div class="message">
        <div class="mess-header">Orders</div>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Username</th>
                        <th>Placed on</th>
                        <th>Phone no.</th>
                        <th>Price</th>
                        <th>Address</th>
                        <th>Total Products</th>
                        <th>Status</th>
                        <th>Action</th>  <!--- updat/delete - -->
                        </tr>
                    </thead>
                <tbody>
                <?php
                    $select_order = mysqli_query($conn, "SELECT * FROM `order`") or die('query failed');
                    if (mysqli_num_rows($select_order) > 0) {
                        $counter=0;
                    while ($fetch_order = mysqli_fetch_assoc($select_order)) {
                            ?>
                    <tr>
                    <tr id="row-<?php echo $fetch_order['id']; ?>">
                        <td><?php echo ++$counter ?></</td>
                        <td><?php echo $fetch_order['name']?></td>
                        <td><?php echo $fetch_order['placed_on']?></td>
                        <td><?php echo $fetch_order['number']?></td>
                        <td><?php echo $fetch_order['total_price']?></td>
                        <td><?php echo $fetch_order['address']?></td>
                        <td><?php echo $fetch_order['total_product']?></td>
                        <td><form method="POST">
                            <select name="update_payment">
                                <option disabled selected><?php echo $fetch_order['payment_status'];?></option>
                                <option value="pending">Pending</option>
                                <option value="complete">Complete</option>
                            </select>
                        </form></td>
                            <td>
                            <select name="update_status">
                                <option disabled selected><?php echo $fetch_order['action'];?></option>
                                <option value="update">Update</option>
                                <option value="delete">Delete</option>
                                    <!-- <button class="delete-btn-msg"   data-id ="<?php echo $fetch_message['id']; ?>">Delete</button>  -->
                            </td>
                        </tr>
                        <?php }}else{?>
                            <tr>
                                <td colspan="9 ">Data not found</td>
                            </tr>
                         <?php } ?>
                    </tbody>
                </table>
        </div>
    </div>

    <script>
        $(document).on("click", ".delete-btn-msg", function (e) {
        e.preventDefault(); 

        const rowId = $(this).data("id"); 

        // Confirm deletion
        if (confirm("Are you sure you want to delete this message?")) {
            $.ajax({
                url: "admin_message.php", 
                type: "POST",
                data: {
                    delete_id: rowId 
                },
                success: function (response) {
                    if (response === "success") {
                    // If deletion was successful, remove the row from the table
                    $("#row-" + rowId).remove();
                } else {
                    alert("Failed to delete the message.");
                }
            },
            error: function () {
                alert("An error occurred while deleting the message.");
            }
        });
    }
    });
    </script>
</body>

</html>