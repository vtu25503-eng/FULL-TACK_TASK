<?php
session_start();
include 'db.php';

// Fetch all results, joining with users and exams to get names
$query = "SELECT results.*, users.username, exams.exam_name 
          FROM results 
          JOIN users ON results.user_id = users.id 
          JOIN exams ON results.exam_id = exams.id 
          ORDER BY results.submitted_at DESC";
$result = mysqli_query($conn, $query);

// Logic to clear history if needed
if (isset($_GET['clear_id'])) {
    $id = (int)$_GET['delete_id'];
    mysqli_query($conn, "DELETE FROM results WHERE id = $id");
    header("Location: admin_results.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Student Results</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light p-5">
<div class="container">
    <div class="card shadow border-0">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">All Student Attempts</h4>
            <a href="admin_dashboard.php" class="btn btn-outline-light btn-sm">Back to Dashboard</a>
        </div>
        <div class="card-body p-0">
            <table class="table table-striped table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Date</th>
                        <th>Student</th>
                        <th>Exam Name</th>
                        <th>Score</th>
                        <th>Percentage</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($result)): 
                        $percent = ($row['score'] / $row['total_questions']) * 100;
                    ?>
                    <tr>
                        <td><?php echo date('M d, Y', strtotime($row['submitted_at'])); ?></td>
                        <td><strong><?php echo $row['username']; ?></strong></td>
                        <td><?php echo $row['exam_name']; ?></td>
                        <td><?php echo $row['score']; ?> / <?php echo $row['total_questions']; ?></td>
                        <td><?php echo round($percent, 1); ?>%</td>
                        <td>
                            <?php if($percent >= 50): ?>
                                <span class="badge bg-success">Passed</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Failed</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>