<?php
session_start();
include 'db.php';

// --- SECURITY: Admin Only ---
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// --- LOGIC: Fetch All Results with Related Data ---
$sql = "SELECT u.username, e.exam_title, r.score, r.status, r.date_time 
        FROM results r
        JOIN users u ON r.user_id = u.id
        JOIN exams e ON r.exam_id = e.id
        ORDER BY r.date_time DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Global Results Report</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .badge-pass { background-color: #198754; }
        .badge-fail { background-color: #dc3545; }
    </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-dark mb-4">
    <div class="container">
        <span class="navbar-brand">Admin: Performance Reports</span>
        <a href="admin_dashboard.php" class="btn btn-outline-light btn-sm">Back to Dashboard</a>
    </div>
</nav>

<div class="container">
    <div class="card shadow">
        <div class="card-header bg-white">
            <h4 class="mb-0">All Student Exam Submissions</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered mt-3">
                    <thead class="table-dark">
                        <tr>
                            <th>Student Name</th>
                            <th>Exam Title</th>
                            <th>Score</th>
                            <th>Status</th>
                            <th>Date & Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0): ?>
                            <?php while($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><strong><?php echo htmlspecialchars($row['username']); ?></strong></td>
                                    <td><?php echo htmlspecialchars($row['exam_title']); ?></td>
                                    <td><?php echo $row['score']; ?></td>
                                    <td>
                                        <span class="badge <?php echo ($row['status'] == 'Pass') ? 'badge-pass' : 'badge-fail'; ?>">
                                            <?php echo strtoupper($row['status']); ?>
                                        </span>
                                    </td>
                                    <td><?php echo date("M d, Y - h:i A", strtotime($row['date_time'])); ?></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center">No results found in the system.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

</body>
</html>