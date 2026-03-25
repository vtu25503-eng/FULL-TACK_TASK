<?php
session_start();
include 'db.php';

// Security: If not logged in, kick back to login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch questions from database
$query = "SELECT * FROM questions";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Online Exam - Questions</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light p-5">
    <div class="container card shadow p-4" style="max-width: 700px;">
        <h2 class="text-center text-primary">Examination Sheet</h2>
        <p class="text-center">Welcome, <b><?php echo $_SESSION['username']; ?></b>! Answer all questions below.</p>
        <hr>

        <form action="submit_results.php" method="POST">
            <?php 
            $i = 1;
            while($row = mysqli_fetch_assoc($result)) { ?>
                <div class="mb-4">
                    <h5><?php echo $i++ . ". " . $row['question_text']; ?></h5>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="q[<?php echo $row['id']; ?>]" value="A" required>
                        <label class="form-check-label"><?php echo $row['option_a']; ?></label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="q[<?php echo $row['id']; ?>]" value="B">
                        <label class="form-check-label"><?php echo $row['option_b']; ?></label>
                    </div>
                </div>
            <?php } ?>
            
            <button type="submit" class="btn btn-success w-100 py-2">Submit Exam</button>
        </form>
    </div>
</body>
</html>