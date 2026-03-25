<?php
include 'db.php';

// 1. Insert a Test Exam
$exam_sql = "INSERT INTO exams (exam_name, duration) VALUES ('General Knowledge Quiz', 15)";
mysqli_query($conn, $exam_sql);
$exam_id = mysqli_insert_id($conn);

// 2. Insert 5 Test Questions
$questions = [
    ["What is the capital of France?", "London", "Berlin", "Paris", "Madrid", "C"],
    ["Which planet is known as the Red Planet?", "Earth", "Mars", "Jupiter", "Saturn", "B"],
    ["What is 5 + 7?", "10", "11", "12", "13", "C"],
    ["Who wrote 'Romeo and Juliet'?", "Charles Dickens", "Mark Twain", "William Shakespeare", "Jane Austen", "C"],
    ["What is the largest ocean on Earth?", "Atlantic", "Indian", "Arctic", "Pacific", "D"]
];

foreach ($questions as $q) {
    $sql = "INSERT INTO questions (exam_id, question_text, option_a, option_b, option_c, option_d, correct_option) 
            VALUES ($exam_id, '$q[0]', '$q[1]', '$q[2]', '$q[3]', '$q[4]', '$q[5]')";
    mysqli_query($conn, $sql);
}

echo "<h1>Success!</h1>";
echo "<p>A new exam has been created with ID: <b>$exam_id</b></p>";
echo "<p><a href='view_exams.php'>Go to Exam List</a> to test it!</p>";
?>