<?php
session_start();
include("koneksi.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
    
}

$user_id = $_SESSION['user_id'];

// Menandai task selesai
if (isset($_GET['complete'])) {
    $task_id = $_GET['complete'];

    mysqli_query(
        $koneksi,
        "UPDATE tasks 
         SET status = 1 
         WHERE id = $task_id AND user_id = $user_id"
    );

    header("Location: index.php");
    exit;
}

// Mengembalikan task menjadi belum selesai (Undone)
if (isset($_GET['undone'])) {
    $task_id = $_GET['undone'];

    mysqli_query(
        $koneksi,
        "UPDATE tasks 
         SET status = 0 
         WHERE id = $task_id AND user_id = $user_id"
    );

    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task List</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="index.css">
    
</head>
<body class="index-page">

<div class="container index-container mt-2">
    <h2 class="text-center">Task List Application</h2>

    <!-- Tombol ke halaman create -->
    <div class="text-start mb-3">
        <a href="create.php" class="btn btn-purple">
            Add New Task
        </a>
    </div>

    <table class="table table-striped task-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Task</th>
                <th>Description</th>
                <th>Deadline</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $no = 1;
        $result = mysqli_query(
            $koneksi,
            "SELECT * FROM tasks 
             WHERE user_id = $user_id 
             ORDER BY deadline ASC"
        );

        while ($row = mysqli_fetch_assoc($result)) {
        ?>
            <tr>
                <td class="text-center"><?= $no++ ?></td>
                <td><?= $row['task'] ?></td>
                <td><?= $row['description'] ?></td>
                <td><?= $row['deadline'] ?></td>

                <td class="text-center">
                    <span class="task-status 
                        <?= $row['status'] == 0 ? 'status-progress' : 'status-done' ?>">
                        <?= $row['status'] == 0 ? 'In Progress' : 'Done' ?>
                    </span>
                </td>

                <td class="text-center">
                    <?php if ($row['status'] == 0) { ?>
                        <a href="?complete=<?= $row['id'] ?>" 
                           class="btn btn-success btn-sm">
                            Done
                        </a>
                    <?php } else { ?>
                        <a href="?undone=<?= $row['id'] ?>" 
                           class="btn btn-secondary btn-sm">
                            Undone
                        </a>
                    <?php } ?>

                    <a href="edit.php?id=<?= $row['id'] ?>" 
                       class="btn btn-warning btn-sm">
                        Edit
                    </a>

                    <a href="delete.php?id=<?= $row['id'] ?>" 
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('Delete this task?')">
                        Delete
                    </a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>

<!-- Logout --> 
 <div class="index-logout"> 
    <a href="logout.php"> <button class="btn">Logout</button> 
    </a> 
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
