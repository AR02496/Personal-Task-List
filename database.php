<?php

$host = 'localhost';
$port = 3306;
$username = 'root';    
$password = 'AsuKayang69';        
$dbname = 'todolist';  

$koneksi = mysqli_connect($host, $username, $password, $dbname);

if (!$koneksi) {
    die("Error koneksi: " . mysqli_connect_error());
}

mysqli_set_charset($koneksi, "utf8mb4");
?>
