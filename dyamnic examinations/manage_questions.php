<?php
session_start();
include 'db.php';

// Fetch all users
$query = "SELECT * FROM users ORDER BY id DESC";
$result = mysqli_query($conn, $query);

// Logic to delete a user
if (isset($_GET['delete_id'])) {
    $id = (int)$_GET['delete_id'];
    // Prevent the admin from deleting themselves (safety check)
    if ($id != $_SESSION['user_id']) {
        mysqli_query($conn, "DELETE FROM users WHERE id = $id");
        header("Location: manage_users.php?msg=deleted");
    } else {
        header("Location: manage_users.php?msg=error");
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Users</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light p-5">
<div class="container">
    <div class="card shadow border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">User Accounts</h4>
            <a href="admin_dashboard.php" class="btn btn-outline-light btn-sm">Back to Dashboard</a>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><strong><?php echo $row['username']; ?></strong></td>
                        <td><?php echo isset($row['email']) ? $row['email'] : 'N/A'; ?></td>
                        <td>
                            <span class="badge <?php echo ($row['role'] == 'admin') ? 'bg-danger' : 'bg-info'; ?>">
                                <?php echo ucfirst($row['role']); ?>
                            </span>
                        </td>
                        <td>
                            <a href="edit_user.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                            <?php if($row['id'] != $_SESSION['user_id']): ?>
                                <a href="manage_users.php?delete_id=<?php echo $row['id']; ?>" 
                                   class="btn btn-sm btn-danger" 
                                   onclick="return confirm('Permanently delete this user?')">Delete</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>