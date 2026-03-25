<?php
session_start();
include 'db.php';

// 1. Security Check: Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// 2. Fetch the LATEST result for this user from the database
$query = "SELECT r.*, e.exam_title 
          FROM results r 
          JOIN exams e ON r.exam_id = e.id 
          WHERE r.user_id = ? 
          ORDER BY r.date_time DESC LIMIT 1";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) {
    die("No exam records found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Exam Result</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .result-card { max-width: 500px; margin: 50px auto; text-align: center; padding: 30px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .score-circle { font-size: 48px; font-weight: bold; color: #0d6efd; margin: 20px 0; }
        .pass { color: #198754; font-weight: bold; }
        .fail { color: #dc3545; font-weight: bold; }
    </style>
</head>
<body class="bg-light">

<div class="container">
    <div class="card result-card">
        <h2 class="mb-4">Exam Report</h2>
        <p class="text-muted">Exam: <strong><?php echo $data['exam_title']; ?></strong></p>
        <hr>
        
        <div class="score-label">Your Total Score</div>
        <div class="score-circle"><?php echo $data['score']; ?></div>
        
        <p class="fs-4">Status: 
            <span class="<?php echo ($data['status'] == 'Pass') ? 'pass' : 'fail'; ?>">
                <?php echo strtoupper($data['status']); ?>
            </span>
        </p>

        <p class="text-muted small">Completed on: <?php echo date("F j, Y, g:i a", strtotime($data['date_time'])); ?></p>
        
        <div class="mt-4">
            <a href="dashboard.php" class="btn btn-primary w-100">Back to Dashboard</a>
        </div>
    </div>
</div>

</body>
</html>