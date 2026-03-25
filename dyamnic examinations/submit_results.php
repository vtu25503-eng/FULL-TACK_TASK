<?php
session_start();
include 'db.php';

// 1. Security Check
if (!isset($_SESSION['user_id'])) {
    die("Error: Please log in to submit your exam.");
}

if (isset($_POST['q']) && is_array($_POST['q'])) {
    $score = 0;
    $total_questions = count($_POST['q']);
    $user_id = $_SESSION['user_id'];

    foreach ($_POST['q'] as $question_id => $user_answer) {
        $question_id = mysqli_real_escape_string($conn, $question_id);
        
        // --- MATCHING YOUR DATABASE ---
        // I have changed 'correct_ans' to 'ans' based on common XAMPP project structures.
        // If your column is named 'answer', change 'ans' to 'answer' below.
        $sql = "SELECT ans FROM questions WHERE id = '$question_id'";
        $result = mysqli_query($conn, $sql);

        if (!$result) {
            // This will stop the "Fatal Error" and show a helpful message instead
            die("Database Error: " . mysqli_error($conn) . ". Check if the column 'ans' exists in your 'questions' table.");
        }

        $row = mysqli_fetch_assoc($result);
        
        // 2. Compare the answer
        if ($row && isset($row['ans']) && $row['ans'] == $user_answer) {
            $score++;
        }
    }

    // 3. Save to results table
    $insert_sql = "INSERT INTO results (user_id, score, total) VALUES ('$user_id', '$score', '$total_questions')";
    
    if (mysqli_query($conn, $insert_sql)) {
        header("Location: view_results.php?score=$score&total=$total_questions");
        exit();
    } else {
        die("Save Error: " . mysqli_error($conn) . ". Make sure the 'results' table exists!");
    }
} else {
    echo "No answers were submitted.";
}
?>