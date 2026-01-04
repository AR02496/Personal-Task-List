<?php
// src/models/User.php

class User
{
    private $conn; // koneksi database

    public function __construct($koneksi)
    {
        $this->conn = $koneksi;
    }

    // Registrasi user baru
    public function register(string $name, string $email, string $password): array
    {
        // Cek email sudah terdaftar atau belum
        $sql  = "SELECT id FROM users WHERE email = ?";
        $stmt = mysqli_prepare($this->conn, $sql);

        if (!$stmt) {
            return ['success' => false, 'message' => 'Error server (cek email).'];
        }

        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            mysqli_stmt_close($stmt);
            return ['success' => false, 'message' => 'Email sudah terdaftar.'];
        }

        mysqli_stmt_close($stmt);

        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert user baru
        $sql  = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($this->conn, $sql);

        if (!$stmt) {
            return ['success' => false, 'message' => 'Error server (insert user).'];
        }

        mysqli_stmt_bind_param($stmt, "sss", $name, $email, $hashedPassword);

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            return ['success' => true, 'message' => 'Registrasi berhasil.'];
        } else {
            $error = mysqli_error($this->conn);
            mysqli_stmt_close($stmt);
            return ['success' => false, 'message' => 'Registrasi gagal: ' . $error];
        }
    }

    // Login user
    public function login(string $email, string $password): array
    {
        $sql  = "SELECT id, name, email, password FROM users WHERE email = ?";
        $stmt = mysqli_prepare($this->conn, $sql);

        if (!$stmt) {
            return ['success' => false, 'message' => 'Error server (ambil user).'];
        }

        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (!$result || mysqli_num_rows($result) !== 1) {
            mysqli_stmt_close($stmt);
            return ['success' => false, 'message' => 'Email atau password salah.'];
        }

        $user = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);

        // Cek password
        if (!password_verify($password, $user['password'])) {
            return ['success' => false, 'message' => 'Email atau password salah.'];
        }

        return [
            'success' => true,
            'message' => 'Login berhasil.',
            'user'    => $user
        ];
    }
}
