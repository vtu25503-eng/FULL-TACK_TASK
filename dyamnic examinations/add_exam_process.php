<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['exam_name']);
    $time = (int)$_POST['duration'];

    $sql = "INSERT INTO exams (exam_name, duration) VALUES ('$name', $time)";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: manage_exams.php");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>