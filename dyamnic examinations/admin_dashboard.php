<?php
// ... after session_start() and include 'db.php' ...

// Count Total Students
$user_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM users WHERE role='student'"));

// Count Total Exams
$exam_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM exams"));

// Count Total Questions
$ques_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM questions"));
?>