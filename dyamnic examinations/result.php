<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get the score from the URL (sent by submit_results.php)
$score = isset($_GET['score']) ? $_GET['score'] : 0;
$total = isset($_GET['total']) ? $_GET['total'] : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Result</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center">
                <div class="card shadow p-5">
                    <h1 class="text-success">Exam Finished!</h1>
                    <hr>
                    <h3>Your Score: <span class="text-primary"><?php echo $score; ?> / <?php echo $total; ?></span></h3>
                    <p class="lead">Percentage: <?php echo ($total > 0) ? round(($score/$total)*100, 1) : 0; ?>%</p>
                    <a href="view_exams.php" class="btn btn-dark mt-3">Back to Exams</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>