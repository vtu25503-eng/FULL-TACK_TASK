<?php
session_start();
include 'db.php';
include 'admin_check.php';

$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM users WHERE id = $id");
$user = mysqli_fetch_assoc($query);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_username = mysqli_real_escape_string($conn, $_POST['username']);
    $new_role = $_POST['role'];

    $update = "UPDATE users SET username='$new_username', role='$new_role' WHERE id = $id";
    if (mysqli_query($conn, $update)) {
        header("Location: manage_users.php?msg=user_updated");
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light p-5">
<div class="container">
    <div class="card shadow p-4 mx-auto" style="max-width: 500px;">
        <h3>Edit User: <?php echo $user['username']; ?></h3>
        <form method="POST">
            <div class="mb-3">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $user['username']; ?>" required>
            </div>
            <div class="mb-3">
                <label>System Role</label>
                <select name="role" class="form-select">
                    <option value="student" <?php if($user['role'] == 'student') echo 'selected'; ?>>Student</option>
                    <option value="admin" <?php if($user['role'] == 'admin') echo 'selected'; ?>>Admin</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update User</button>
            <a href="manage_users.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
</body>
</html>