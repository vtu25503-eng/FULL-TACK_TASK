<?php
include 'db.php';
$result = $conn->query("SELECT * FROM exams");
?>

<div class="list-group">
    <?php if ($result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()): ?>
            <a href="take_exam.php?id=<?php echo $row['id']; ?>" class="list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1"><?php echo $row['exam_name']; ?></h5>
                    <small><?php echo $row['duration']; ?> mins</small>
                </div>
                <button class="btn btn-sm btn-success mt-2">Start Exam</button>
            </a>
        <?php endwhile; ?>
    <?php else: ?>
        <div class="alert alert-info">No exams available at the moment.</div>
    <?php endif; ?>
</div>