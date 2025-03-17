<?php
include_once 'include/admin_header.php';

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


//delete products from database
if ($conn) {
    function getData($conn)
    {
        $dataSql = "SELECT * FROM user";
        $dataResult = $conn->query($dataSql);
        return $dataResult;
    }
    $dataResult = getData($conn);


    // print_r($dataResult->num_rows );


    if (isset($_POST['delete'])) {
        $delete_id = $_POST['delete'];
        $deleteSql = "DELETE FROM user WHERE user_id = $delete_id";
        $res = $conn->query($deleteSql);
        if ($res) {
            echo "data has been deleted";
            $dataResult = getData($conn);
        } else {
            echo "data not has been deleted";
        }
    }
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
        <div class="mess-header">User</div>
        <div class="card-container">
            <?php if ($dataResult->num_rows > 0) {
                while ($row = $dataResult->fetch_assoc()) { ?>
                    <div class="single-card1" style="height: 350px;">
                        <div class="img-area1">
                        <img src="./image/<?php echo htmlspecialchars($row['profile_image']); ?>" alt="Profile Image">

                        </div>
                        <div class="info1">
                            <h3><?php echo htmlspecialchars($row['user_name']); ?></h3>
                            <p>Email: <?php echo htmlspecialchars($row['email']); ?></p>
                            <p>User ID: <?php echo htmlspecialchars($row['user_id']); ?></p>

                            <a href="./edit.php?id=<?php echo $row['user_id']; ?>" class="edit">Edit</a>
                            <a href="profile.php?delete=<?php echo $row['user_id']; ?>" class="delete" onclick="return confirm('Want to delete this user?');">Delete</a>
                        </div>
                    </div>
                <?php }
            } else { ?>
                <div class="empty">
                    <p>No users found!</p>
                </div>
            <?php } ?>
        </div>


    </div>



    <script src="./assets/js/script.js"></script>

</body>

</html>