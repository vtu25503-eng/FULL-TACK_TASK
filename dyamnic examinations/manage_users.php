<?php
// 1. Start session and show all errors
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 2. Include database
if (!file_exists('db.php')) { die("Error: db.php file is missing in this folder!"); }
include 'db.php';

// 3. Check if user is actually logged in as Admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "<h3>Access Denied!</h3>";
    echo "Current Session Role: " . ($_SESSION['role'] ?? 'Not Logged In') . "<br>";
    echo "<a href='login.php'>Click here to login as Admin</a>";
    exit();
}

// 4. Fetch Users
$query = "SELECT * FROM users";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Database Query Failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Management</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light p-5">
<div class="container bg-white p-4 shadow-sm border-0">
    <h2>User Management</h2>
    <hr>
    <table class="table table-striped mt-4">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Role</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['username']; ?></td>
                <td><span class="badge bg-info text-dark"><?php echo $row['role']; ?></span></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <br>
    <a href="admin_dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
</div>
</body>
</html>