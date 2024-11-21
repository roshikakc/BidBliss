<?php

include 'database.php';

if(isset($_POST['submit-btn'])){
    $name=mysqli_real_escape_string($conn,$_POST['name']);
    $email=mysqli_real_escape_string($conn,$_POST['email']);
    $password=mysqli_real_escape_string($conn,md5($_POST['password']) );
    $cpassword=mysqli_real_escape_string($conn,md5($_POST['cpassword']) );

    $select_users=mysqli_query($conn,"SELECT * FROM `user` WHERE email='$email' AND password='$password'") or die('query failed');

    if(mysqli_num_rows($select_users) > 0){
        $message[]='User already exists!';
    }else{
        if($password!=$cpassword){
            $message[]='Wrong password!';
        }
        else{
            mysqli_query($conn,"INSERT INTO `user`(name,email, password) VALUES('$name','$email','$password')") or die('query failed');
            $message[]='Registered Successfully!';
            header('location:login.php');
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
<section class="form-container">
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
        <form method="post">
            <h1>register now</h1>
            <input type="text" name="name" placeholder="enter your name" required>
            <input type="email" name="email" placeholder="enter your email" required>
            <input type="password" name="password" placeholder="enter your password" required>
            <input type="password" name="cpassword" placeholder="conform your password" required>
            <input type="submit" name="submit-btn" value="register now" class="btn">
            <p>already have an account? <a href="login.php">login now</a></p>
        </form>
    </section>
</body>
</html>