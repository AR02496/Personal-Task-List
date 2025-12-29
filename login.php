<?php
include("koneksi.php");
session_start();

$msg='';
if(isset($_POST['submit'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $select1 = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
    $select_user = mysqli_query($koneksi, $select1);
    if(mysqli_num_rows($select_user) > 0){
        $se1 = mysqli_fetch_assoc($select_user);
       $_SESSION['user_id'] = $se1['id'];
        $_SESSION['name'] = $se1['name'];
        $_SESSION['email'] = $se1['email'];
        

        header('location:index.php');
    }
    else{
        $msg= "Incorrect email and password!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task List</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
    <div class="form">
        <form action="" method="post">
            <h2>Login</h2>
            <p class="msg text-danger">
                 <?php echo $msg; ?>
            </p>

            
            <div class="form-group">
                <input type="email" name="email" placeholder="Enter your email" class="form-control" required>
            </div>
           <div class="form-group">
                <input type="password" name="password" placeholder="Enter your password" class="form-control" required>
            </div>
            <button class="btn font-weight-bold" name="submit">Login Now</button>
            <p>Don't have an Account? <a href="register.php">Register Now</a></p>
</form>
    </div>
</body>
</html>