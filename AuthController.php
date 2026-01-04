<?php
// src/controllers/AuthController.php

session_start();

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/User.php';

class AuthController
{
    private $userModel;

    public function __construct($koneksi)
    {
        $this->userModel = new User($koneksi);
    }

    // Tampilkan halaman login
    public function showLogin(): void
    {
        $error = $_SESSION['login_error'] ?? '';
        unset($_SESSION['login_error']);

        include __DIR__ . '/../views/auth/login.php';
    }

    // Tampilkan halaman register
    public function showRegister(): void
    {
        $error = $_SESSION['register_error'] ?? '';
        unset($_SESSION['register_error']);

        include __DIR__ . '/../views/auth/register.php';
    }

    // Proses form login
    public function handleLogin(): void
    {
        $email    = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($email === '' || $password === '') {
            $_SESSION['login_error'] = 'Email dan password wajib diisi.';
            header('Location: auth.php?action=login');
            exit;
        }

        $result = $this->userModel->login($email, $password);

        if (!$result['success']) {
            $_SESSION['login_error'] = $result['message'] ?? 'Login gagal.';
            header('Location: auth.php?action=login');
            exit;
        }

        $user = $result['user'];

        // Amankan session
        session_regenerate_id(true);

        // Simpan data user ke session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name']    = $user['name'];
        $_SESSION['email']   = $user['email'];

        header('Location: index.php');
        exit;
    }

    // Proses form register
    public function handleRegister(): void
    {
        $name      = trim($_POST['name'] ?? '');
        $email     = trim($_POST['email'] ?? '');
        $password  = $_POST['password'] ?? '';
        $cpassword = $_POST['cpassword'] ?? '';

        if ($name === '' || $email === '' || $password === '' || $cpassword === '') {
            $_SESSION['register_error'] = 'Semua field wajib diisi.';
            header('Location: auth.php?action=register');
            exit;
        }

        if ($password !== $cpassword) {
            $_SESSION['register_error'] = 'Password dan konfirmasi tidak sama.';
            header('Location: auth.php?action=register');
            exit;
        }

        $result = $this->userModel->register($name, $email, $password);

        if (!$result['success']) {
            $_SESSION['register_error'] = $result['message'] ?? 'Registrasi gagal.';
            header('Location: auth.php?action=register');
            exit;
        }

        // Jika berhasil, kembali ke login
        header('Location: auth.php?action=login');
        exit;
    }

    // Logout user
    public function logout(): void
    {
        $_SESSION = [];
        session_destroy();

        header('Location: auth.php?action=login');
        exit;
    }
}
