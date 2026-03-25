<?php
session_start();
include 'db.php';

// 1. Get the ID from the URL
if (!isset($_GET['id'])) {
    header("Location: manage_questions.php");
    exit();
}

$id = (int)$_GET['id'];

// 2. Fetch the current data for this specific question
$query = mysqli_query($conn, "SELECT * FROM questions WHERE id = $id");
$q_data = mysqli_fetch_assoc($query);

if (!$q_data) {
    die("Question not found.");
}

// 3. Handle the Update (Post Request)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $question = mysqli_real_escape_string($conn, $_POST['question_text']);
    $a = mysqli_real_escape_string($conn, $_POST['option_a']);
    $b = mysqli_real_escape_string($conn, $_POST['option_b']);
    $c = mysqli_real_escape_string($conn, $_POST['option_c']);
    $d = mysqli_real_escape_string($conn, $_POST['option_d']);
    $correct = $_POST['correct_option'];

    $update_sql = "UPDATE questions SET 
                   question_text='$question', 
                   option_a='$a', option_b='$b', option_c='$c', option_d='$d', 
                   correct_option='$correct' 
                   WHERE id = $id";

    if (mysqli_query($conn, $update_sql)) {
        header("Location: manage_questions.php?msg=updated");
    } else {
        $error = "Update failed: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Question</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light p-5">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow border-0">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0">Edit Question #<?php echo $id; ?></h4>
                </div>
                <div class="card-body">
                    <?php if(isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
                    
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Question Text</label>
                            <textarea name="question_text" class="form-control" rows="3" required><?php echo htmlspecialchars($q_data['question_text']); ?></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Option A</label>
                                <input type="text" name="option_a" class="form-control" value="<?php echo htmlspecialchars($q_data['option_a']); ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Option B</label>
                                <input type="text" name="option_b" class="form-control" value="<?php echo htmlspecialchars($q_data['option_b']); ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Option C</label>
                                <input type="text" name="option_c" class="form-control" value="<?php echo htmlspecialchars($q_data['option_c']); ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Option D</label>
                                <input type="text" name="option_d" class="form-control" value="<?php echo htmlspecialchars($q_data['option_d']); ?>" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Correct Answer</label>
                            <select name="correct_option" class="form-select">
                                <option value="A" <?php if($q_data['correct_option'] == 'A') echo 'selected'; ?>>A</option>
                                <option value="B" <?php if($q_data['correct_option'] == 'B') echo 'selected'; ?>>B</option>
                                <option value="C" <?php if($q_data['correct_option'] == 'C') echo 'selected'; ?>>C</option>
                                <option value="D" <?php if($q_data['correct_option'] == 'D') echo 'selected'; ?>>D</option>
                            </select>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="manage_questions.php" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>