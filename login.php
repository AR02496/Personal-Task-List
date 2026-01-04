<?php
// src/views/auth/login.php
// View untuk halaman login user.
// Variabel $error dikirim dari AuthController::showLogin()
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task List - Login</title>

    <!-- Menggunakan CSS custom project.
         Path relatif terhadap public/auth.php sebagai entry point. -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <!-- Container utama form login -->
    <div class="form">
        <!-- Form login: dikirim ke auth.php dengan action=login (method POST)
             Prosesnya ditangani oleh AuthController::handleLogin(). -->
        <form action="auth.php?action=login" method="post">
            <h2>Login</h2>

            <!-- Menampilkan pesan error jika proses login sebelumnya gagal.
                 htmlspecialchars digunakan untuk mencegah cross site scripting. -->
            <?php if (!empty($error)): ?>
                <p class="msg text-danger">
                    <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?>
                </p>
            <?php endif; ?>

            <!-- Input email.
                 Value otomatis terisi dari cookie 'remember_email' (fitur Remember Me). -->
            <div class="form-group">
                <input
                    type="email"
                    name="email"
                    placeholder="Enter your email"
                    class="form-control"
                    value="<?= htmlspecialchars($_COOKIE['remember_email'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                    required
                >
            </div>

            <!-- Input password -->
            <div class="form-group">
                <input
                    type="password"
                    name="password"
                    placeholder="Enter your password"
                    class="form-control"
                    required
                >
            </div>

            <!-- Checkbox Remember Me.
                 Jika dicentang, controller akan menyimpan email di cookie. -->
            <div class="form-group form-check">
                <input
                    type="checkbox"
                    name="remember"
                    class="form-check-input"
                    id="remember"
                    <?= isset($_COOKIE['remember_email']) ? 'checked' : ''; ?>
                >
                <label class="form-check-label" for="remember">
                    Remember Me
                </label>
            </div>

            <!-- Tombol submit untuk login -->
            <button class="btn btn-primary font-weight-bold" type="submit" name="submit">
                Login Now
            </button>

            <!-- Link ke halaman registrasi -->
            <p>
                Don't have an account?
                <a href="auth.php?action=register">Register Now</a>
            </p>
        </form>
    </div>
</body>
</html>
