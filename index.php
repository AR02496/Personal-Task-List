<?php

session_start();

$rootPath = dirname(__DIR__);

require $rootPath . '/src/config/database.php';
require $rootPath . '/src/controllers/AuthController.php';
require $rootPath . '/src/controllers/TaskController.php';

if (!isset($_SESSION['user_id'])) {
    $authController = new AuthController($pdo);
    $authController->showLoginForm();
    exit;
}

$taskController = new TaskController($pdo);
$taskController->index();
