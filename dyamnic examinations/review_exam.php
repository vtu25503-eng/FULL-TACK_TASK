<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['exam_id'])) {
    header("Location: view_exams.php");
    exit();
}

$exam_id = (int)$_GET['exam_id'];
$user_id = $_SESSION['user_id'];

// Fetch questions for this exam
$query = $conn->prepare("SELECT * FROM questions WHERE exam_id = ?");
$query->bind_param("i", $exam_id);
$query->execute();
$questions = $query->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Review Exam</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .correct { background-color: #d4edda; border: 1px solid #c3e6cb; color: #155724; }
        .wrong { background-color: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; }
        .option-box { padding: 10px; margin: 5px 0; border-radius: 5px; border: 1px solid #ddd; }
    </style>
</head>
<body class="bg-light">
    <div class="container mt-5 mb-5">
        <h2 class="text-center mb-4">Exam Review</h2>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <?php 
                $q_count = 1;
                while ($row = $questions->fetch_assoc()): 
                    $correct = $row['correct_option'];
                ?>
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h5>Q<?php echo $q_count++; ?>: <?php echo $row['question_text']; ?></h5>
                        
                        <?php 
                        $options = ['A' => $row['option_a'], 'B' => $row['option_b'], 'C' => $row['option_c'], 'D' => $row['option_d']];
                        foreach ($options as $key => $value):
                            $class = "";
                            // Highlight the correct answer in green
                            if ($key == $correct) {
                                $class = "correct";
                            }
                        ?>
                            <div class="option-box <?php echo $class; ?>">
                                <strong><?php echo $key; ?>)</strong> <?php echo $value; ?>
                                <?php if ($key == $correct) echo " <span class='badge bg-success'>Correct Answer</span>"; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endwhile; ?>
                
                <div class="text-center mt-4">
                    <a href="view_exams.php" class="btn btn-dark">Back to My Exams</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>