<?php
session_start();
include 'db.php';

// Optional: Add a check here to ensure only admins can access this
// if ($_SESSION['role'] != 'admin') { header("Location: index.php"); exit(); }

// Fetch exams for the dropdown
$exams = $conn->query("SELECT id, exam_name FROM exams");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $exam_id = $_POST['exam_id'];
    $question = $_POST['question_text'];
    $a = $_POST['option_a'];
    $b = $_POST['option_b'];
    $c = $_POST['option_c'];
    $d = $_POST['option_d'];
    $correct = $_POST['correct_option'];

    $stmt = $conn->prepare("INSERT INTO questions (exam_id, question_text, option_a, option_b, option_c, option_d, correct_option) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssss", $exam_id, $question, $a, $b, $c, $d, $correct);

    if ($stmt->execute()) {
        $success = "Question added successfully!";
    } else {
        $error = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Question - Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Add New Question</h4>
                </div>
                <div class="card-body">
                    <?php if(isset($success)) echo "<div class='alert alert-success'>$success</div>"; ?>
                    <?php if(isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>

                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Select Exam</label>
                            <select name="exam_id" class="form-select" required>
                                <option value="">-- Choose Exam --</option>
                                <?php while($row = $exams->fetch_assoc()): ?>
                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['exam_name']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Question Text</label>
                            <textarea name="question_text" class="form-control" rows="3" required></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Option A</label>
                                <input type="text" name="option_a" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Option B</label>
                                <input type="text" name="option_b" class="form-control" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Option C</label>
                                <input type="text" name="option_c" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Option D</label>
                                <input type="text" name="option_d" class="form-control" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Correct Option</label>
                            <select name="correct_option" class="form-select" required>
                                <option value="A">Option A</option>
                                <option value="B">Option B</option>
                                <option value="C">Option C</option>
                                <option value="D">Option D</option>
                            </select>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success">Save Question</button>
                            <a href="admin_dashboard.php" class="btn btn-outline-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>