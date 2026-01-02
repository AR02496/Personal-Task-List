<?php
include("koneksi.php");
session_start();

$msg='';

if (isset($_POST['submit'])) {

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Prepared Statement (Anti SQL Injection)
    $stmt = mysqli_prepare(
        $koneksi,
        "SELECT id, name, email, password FROM users WHERE email = ?"
    );

    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) === 1) {
        $se1 = mysqli_fetch_assoc($result);

        // Verify hashed password
        if (password_verify($password, $se1['password'])) {

            // Session variables (same as previous code)
            $_SESSION['user_id'] = $se1['id'];
            $_SESSION['name']    = $se1['name'];
            $_SESSION['email']   = $se1['email'];

            // ===== COOKIE (REMEMBER ME) =====
            if (isset($_POST['remember'])) {
                setcookie(
                    "remember_email",
                    $se1['email'],
                    time() + (86400 * 7), // 7 days
                    "/",
                    "",
                    false, // set true if using HTTPS
                    true   // HttpOnly
                );
            } else {
                // If checkbox not checked, delete cookie
                setcookie("remember_email", "", time() - 3600, "/");
            }
            // ================================

            header("Location: index.php");
            exit;
        } else {
            $msg = "Incorrect email or password!";
        }
    } else {
        $msg = "Incorrect email or password!";
    }

    mysqli_stmt_close($stmt);
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
                <input type="email" name="email" placeholder="Enter your email" class="form-control" value="<?= $_COOKIE['remember_email'] ?? '' ?>" required>
            </div>
           <div class="form-group">
                <input type="password" name="password" placeholder="Enter your password" class="form-control" required>
            </div>

            <!-- Remember Me Checkbox -->
            <div class="form-group form-check">
                <input type="checkbox"
                    name="remember"
                    class="form-check-input"
                    id="remember"
                    <?= isset($_COOKIE['remember_email']) ? 'checked' : '' ?>>
                <label class="form-check-label" for="remember">
                    Remember Me
                </label>
            </div>
            <button class="btn font-weight-bold" name="submit">Login Now</button>
            <p>Don't have an Account? <a href="register.php">Register Now</a></p>
</form>
    </div>
</body>

</html>

