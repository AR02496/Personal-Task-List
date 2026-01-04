<?php

$host = 'localhost';
$username = 'root';    
$password = '';        
$dbname = 'db_todolist';  

$koneksi = mysqli_connect($host, $username, $password, $dbname);

if (!$koneksi) {
    die("Error koneksi: " . mysqli_connect_error());
}

mysqli_set_charset($koneksi, "utf8mb4");
?>
