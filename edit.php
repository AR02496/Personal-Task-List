<?php
include("koneksi.php");
session_start();

/* cek login */
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

/* cek parameter id */
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$task_id = $_GET['id'];

/* ambil data task */
$query = mysqli_query(
    $koneksi,
    "SELECT * FROM tasks 
     WHERE id = '$task_id' AND user_id = '$user_id'"
);

if (mysqli_num_rows($query) == 0) {
    header("Location: index.php");
    exit;
}

$data = mysqli_fetch_assoc($query);

/* update task */
if (isset($_POST['update_task'])) {
    $task        = $_POST['task'];
    $description = $_POST['description'];
    $deadline    = $_POST['deadline'];

    if (!empty($task) && !empty($description) && !empty($deadline)) {
        mysqli_query(
            $koneksi,
            "UPDATE tasks 
             SET task = '$task',
                 description = '$description',
                 deadline = '$deadline'
             WHERE id = '$task_id' AND user_id = '$user_id'"
        );

        header("Location: index.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Task</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    
</head>
<body class="form">

<form method="POST">
    <h2>Edit Task</h2>

    <label class="form-label fw-bold text-start d-block">Task Name</label>
    <input type="text"
           name="task"
           class="form-control mb-2"
           value="<?= $data['task'] ?>"
           required>

    <label class="form-label fw-bold text-start d-block">Description</label>
    <input type="text"
           name="description"
           class="form-control mb-2"
           value="<?= $data['description'] ?>"
           required>

    <label class="form-label fw-bold text-start d-block">Deadline</label>
    <input type="date"
           name="deadline"
           class="form-control mb-3"
           value="<?= $data['deadline'] ?>"
           required>

    <button type="submit"
            name="update_task"
            class="btn btn-primary w-100">
        Update Task
    </button>

    <a href="index.php" class="d-block mt-2 text-center">
        Cancel
    </a>
</form>

</body>
</html>
