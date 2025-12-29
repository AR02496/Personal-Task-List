<?php
include("koneksi.php");

$msg='';

if (isset($_POST['submit'])) {

    $name      = trim($_POST['name']);
    $email     = trim($_POST['email']);
    $password  = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    // 1. Check password confirmation
    if ($password !== $cpassword) {
        $msg = "Password and confirm password do not match!";
    } else {

        // 2. Check if email already exists
        $stmt_check = mysqli_prepare(
            $koneksi,
            "SELECT id FROM users WHERE email = ?"
        );
        mysqli_stmt_bind_param($stmt_check, "s", $email);
        mysqli_stmt_execute($stmt_check);
        $result_check = mysqli_stmt_get_result($stmt_check);

        if (mysqli_num_rows($result_check) > 0) {
            $msg = "Email already exists!";
        } else {

            // 3. Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // 4. Insert new user (prepared statement)
            $stmt_insert = mysqli_prepare(
                $koneksi,
                "INSERT INTO users (name, email, password) VALUES (?, ?, ?)"
            );
            mysqli_stmt_bind_param(
                $stmt_insert,
                "sss",
                $name,
                $email,
                $hashed_password
            );

            if (mysqli_stmt_execute($stmt_insert)) {
                header("Location: login.php");
                exit;
            } else {
                $msg = "Registration failed. Please try again.";
            }

            mysqli_stmt_close($stmt_insert);
        }

        mysqli_stmt_close($stmt_check);
    }
}   
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task List</title>
    
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form">
        <form action="" method="post">
            <h2>Registration</h2>
            <p class="msg"><?php echo $msg; ?></p>

            <div class="form-group">
                <input type="text" name="name" placeholder="Enter your name" class="form-control" required>
            </div>
            <div class="form-group">
                <input type="email" name="email" placeholder="Enter your email" class="form-control" required>
            </div>
           <div class="form-group">
                <input type="password" name="password" placeholder="Enter your password" class="form-control" required>
            </div>
            <div class="form-group">
                <input type="password" name="cpassword" placeholder="Confirm your password" class="form-control" required>
            </div>
            <button class="btn font-weight-bold" name="submit">Register Now</button>
            <p>Already have an Account? <a href="login.php">Login Now</a></p>
</form>
    </div>
</body>
</html>
