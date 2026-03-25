<?php
include 'db.php';
$exam_id = 1; // Example Exam ID

// Fetch questions randomly
$query = "SELECT * FROM questions WHERE exam_id = $exam_id ORDER BY RAND()";
$result = $conn->query($query);
?>

<form action="process.php" method="POST">
    <?php while($row = $result->fetch_assoc()): ?>
        <p><?php echo $row['question_text']; ?></p>
        <input type="radio" name="q<?php echo $row['id']; ?>" value="a"> <?php echo $row['option_a']; ?><br>
        <input type="radio" name="q<?php echo $row['id']; ?>" value="b"> <?php echo $row['option_b']; ?><br>
        <?php endwhile; ?>
    <input type="submit" value="Submit Exam">
</form>