<?php
session_start();
include("koneksi.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$task_id = $_GET['id'];

// Hapus task milik user yang sedang login
mysqli_query(
    $koneksi,
    "DELETE FROM tasks 
     WHERE id = $task_id AND user_id = $user_id"
);

header("Location: index.php");
exit;
