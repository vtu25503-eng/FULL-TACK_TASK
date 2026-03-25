<?php
session_start();
include 'db.php'; // Ensure this file has your mysqli connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Security Check: Ensure user is logged in
    if (!isset($_SESSION['user_id'])) {
        die("Unauthorized access. Please log in.");
    }

    $user_id = $_SESSION['user_id']; 
    $exam_id = $_POST['exam_id'];    
    $score = 0;
    $total_questions = 0;

    // 2. The Comparison Loop
    if (isset($_POST['answer'])) {
        foreach ($_POST['answer'] as $question_id => $student_choice) {
            $total_questions++;
            
            // Fetch correct answer from DB
            $stmt = $conn->prepare("SELECT correct_answer FROM questions WHERE id = ?");
            $stmt->bind_param("i", $question_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            if ($row && $row['correct_answer'] == $student_choice) {
                $score++;
            }
        }
    }

    // 3. Final Calculation and Database Insert
    $status = ($score >= ($total_questions / 2)) ? "Pass" : "Fail";
    
    $insert = $conn->prepare("INSERT INTO results (user_id, exam_id, score, status) VALUES (?, ?, ?, ?)");
    $insert->bind_param("iiis", $user_id, $exam_id, $score, $status);
    $insert->execute();

    // 4. Redirect to a "Thank You" or Result page
    header("Location: results_view.php?score=$score&total=$total_questions");
    exit();
}
?>