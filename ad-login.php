<?php
include 'database.php';
session_start();

if(isset($_POST['submit-btn'])){
    $email=mysqli_real_escape_string($conn,$_POST['email']);
    $password=mysqli_real_escape_string($conn,md5($_POST['password']) );

    $select_users=mysqli_query($conn,"SELECT * FROM `user` WHERE email='$email' AND password='$password'") or die('query failed');

    if(mysqli_num_rows($select_users) > 0){
        $row =mysqli_fetch_assoc($select_users);
        
       if($row['user_type']== 'admin'){
        $_SESSION['admin_name']=$row['name'];
        $_SESSION['admin_email']=$row['email'];
        $_SESSION['admin_id']=$row['id'];
        // echo "admin";
        
        header('location:admin_page.php');
        exit;
       }
    //    else if($row['user_type']== 'user'){
    //     $_SESSION['user_name']=$row['name'];
    //     $_SESSION['user_email']=$row['email'];
    //     $_SESSION['user_id']=$row['id'];
    //     // echo "user";
        
    //     header('location:in.php');
    //     exit;}
    else{
        $message[]= 'incorrect email or password';
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
    <link rel="stylesheet" href="./assets/css/admin.css">
</head>
<body>
<?php
    if(isset($message)){
        foreach ($message as $message){
            echo '
            <div class="message1">
            <span>'.$message.' </span>
            <i class= "fa-regular fa-circle-xmark" onclick="this.parentElement.remove()"></i>
            </div>
              ';
        }
    }
    ?>
<section class="form-container">
        <form method="post">
            <h1>login now</h1>
            <div class="input-field">
                <label>email</label><br>
                <input type="email" name="email" placeholder="enter your email" required>
            </div>
            <div class="input-field">
                <label>password</label><br>
                <input type="password" name="password" placeholder="enter your password" required>
            </div>
            <input type="submit" name="submit-btn" value="login now" class="btn">
            <p>do not have an account? <a href="register.php">register now</a></p>
        </form>
    </section>
</body>
</html> 