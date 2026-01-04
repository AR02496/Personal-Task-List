<?php
// Konfigurasi koneksi ke database MySQL
$host = 'localhost';
$port = 3306;
$username = 'root';
$password = ''; // GANTI password sesuai dengan local instance masing-masing
$dbname = 'todolist'; 

// Membuat koneksi
$koneksi = mysqli_connect($host, $username, $password, $dbname, $port);

// Cek koneksi
if (!$koneksi) {
    die("Error koneksi: " . mysqli_connect_error());
}

// Set charset untuk mendukung UTF-8
mysqli_set_charset($koneksi, "utf8mb4");
?>
