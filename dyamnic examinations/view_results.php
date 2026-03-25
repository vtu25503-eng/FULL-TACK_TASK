<?php
session_start();
include 'db.php';

// 1. Security Check
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];

// 2. Fetch Logic: Admin sees all, Student sees self
if ($role == 'admin') {
    $query = "SELECT results.*, users.username FROM results 
              JOIN users ON results.user_id = users.id 
              ORDER BY results.date_taken DESC";
} else {
    $query = "SELECT * FROM results WHERE user_id = $user_id ORDER BY date_taken DESC";
}

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Exam Results</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light p-5">
<div class="container card shadow p-4">
    <h2 class="text-center"><?php echo ($role == 'admin') ? "All Student Results" : "My Exam History"; ?></h2>
    <hr>
    <table class="table table-bordered table-striped mt-3">
        <thead class="table-dark">
            <tr>
                <?php if($role == 'admin'): ?> <th>Student Name</th> <?php endif; ?>
                <th>Score</th>
                <th>Total Questions</th>
                <th>Percentage</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <?php if($role == 'admin'): ?> <td><?php echo $row['username']; ?></td> <?php endif; ?>
                <td><?php echo $row['score']; ?></td>
                <td><?php echo $row['total']; ?></td>
                <td>
                    <?php 
                        $percent = ($row['score'] / $row['total']) * 100;
                        echo number_format($percent, 2) . "%";
                    ?>
                </td>
                <td><?php echo $row['date_taken']; ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <a href="dashboard.php" class="btn btn-secondary mt-3">Back to Dashboard</a>
</div>
</body>
</html>