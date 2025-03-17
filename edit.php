<?php
include_once 'include/admin_header.php';
include 'database.php';

$admin_id = $_SESSION['admin_name'];

if (!isset($admin_id)) {
    header('location:login.php');
    exit;
}

if (isset($_POST['logout'])) {
    session_destroy();
    header('location:login.php');
    exit;
}

$user_id = $_GET['id'];
if ($conn) {
    $dataSql = "SELECT * FROM `user` WHERE user_id = $user_id";
    $dataResult = $conn->query($dataSql);
    $row = $dataResult->fetch_assoc();

    if (isset($_POST['update'])) {
        $user_name = $_POST['user_name'];

        // Handle profile image update
        if (!empty($_FILES['profile_image']['name'])) {
            $image_name = $_FILES['profile_image']['name'];
            $image_tmp = $_FILES['profile_image']['tmp_name'];
            $image_path = "image/" . $image_name;
            move_uploaded_file($image_tmp, $image_path);

            $sql = "UPDATE user SET 
                    user_name='$user_name',
                    profile_image='$image_name'
                    WHERE user_id=$user_id";
        } else {
            $sql = "UPDATE user SET user_name='$user_name' WHERE user_id=$user_id";
        }

        $result = $conn->query($sql);
        if ($result) {
            echo "<script>alert('User updated successfully');</script>";
            header("Location: ./admin_user.php");
            exit;
        } else {
            echo "<script>alert('Failed to update user');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="./assets/css/admin.css">
</head>

<body>
    <div class="dynamic-content home">
        <div class="mess-header">Edit User</div>
        <div class="card-container">
            <div class="single-card-1" style="height: 400px;">
                <div class="img-area-1">
                    <img src="./image/<?php echo !empty($row['profile_image']) ? htmlspecialchars($row['profile_image']) : 'default-avatar.jpg'; ?>" alt="Profile Image">
                </div>
                <div class="info-1">
                    <form action="" method="POST" enctype="multipart/form-data">
                        <label>Username:</label>
                        <input type="text" name="user_name" value="<?php echo htmlspecialchars($row['user_name']); ?>" required>

                        <label>Change Profile Image:</label>
                        <input type="file" name="profile_image" accept="image/*">

                        <button type="submit" name="update" class="submit-btn-msg" value="<?php echo $row['user_id']; ?>">Update</button>
                        <button type="reset" class="reset-btn-msg">Reset</button>
                    </form>
                </div>
            </div>
            <a href="./admin_user.php" class="view-btn-msg">Back to Users</a>
        </div>
    </div>
</body>

</html>
