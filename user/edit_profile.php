<?php
include_once 'include/user_header.php';
include './../database.php';

// Check if user is logged in
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Fetch user data
    $query = "SELECT * FROM `user` WHERE `user_id` = '$user_id'";
    $result = mysqli_query($conn, $query);
    $user_data = mysqli_fetch_assoc($result);

  
    if (isset($_POST['update_profile'])) {
        $new_username = mysqli_real_escape_string($conn, $_POST['username']);
    
        if (!empty($_FILES['profile_image']['name'])) {
            $profile_image = $_FILES['profile_image']['name'];
            $profile_image_tmp_name = $_FILES['profile_image']['tmp_name'];
            $image_folder = './../image/' . $profile_image;
    
            if ($_FILES['profile_image']['size'] > 2000000) {
                $message[] = 'Image size too large';
            } else {
                
                if (move_uploaded_file($profile_image_tmp_name, $image_folder)) {
                    $update_image_query = "UPDATE `user` SET profile_image = '$profile_image' WHERE user_id = '$user_id'";
                    mysqli_query($conn, $update_image_query);
                }
            }
        }
    
        // Update the username
        if (!empty($new_username)) {
            $update_username_query = "UPDATE `user` SET user_name = '$new_username' WHERE user_id = '$user_id'";
            mysqli_query($conn, $update_username_query);
        }
    
        $message[] = 'Profile updated successfully!';
        
        
        header("Location: profile.php");
        exit; 
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="./assets/css/user_style.css">
    <link rel="stylesheet" href="./assets/css/user.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>

<body>
    <div class="profile-container-edit">
        <h2>Edit Profile</h2>
        <!-- Show success or error message -->
        <?php if (isset($message)) {
            foreach ($message as $msg) {
                echo '<p>' . $msg . '</p>';
            }
        } ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($user_data['user_name']); ?>" required>
            </div>

            <div class="form-group">
                <label for="profile_image">Profile Image:</label>
                <input type="file" name="profile_image" id="profile_image" accept="image/*">
            </div>

            <button type="submit" name="update_profile">Update Profile</button>
        </form>

        <div class="profile-info-edit">
            <h3>Current Profile</h3>
            <img src="./../image/<?php echo $user_data['profile_image']; ?>" alt="Profile Image" style="width: 150px; height: 150px;">
            <p>Username: <?php echo htmlspecialchars($user_data['user_name']); ?></p>
        </div>
    </div>
</body>

</html>
