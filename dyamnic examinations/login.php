<?php
// 1. Start session and show errors for debugging
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 2. Connect to the database
include 'db.php'; 

if (isset($_POST['login_btn'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // 3. Query the database
    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $query);

    // 4. Check if user exists (FIXED TYPO HERE)
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        
        // 5. Set Session Variables
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['role']; 

        // 6. Redirect based on role
        if ($_SESSION['role'] == 'admin') {
            header("Location: admin_dashboard.php");
            exit();
        } else {
            header("Location: dashboard.php");
            exit();
        }
    } else {
        $error = "Invalid Username or Password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Online Exam System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light d-flex align-items-center vh-100">
    <div class="container card shadow-sm p-4" style="max-width: 400px;">
        <h3 class="text-center mb-4">Login</h3>
        
        <?php if(isset($error)): ?>
            <div class="alert alert-danger p-2 text-center"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" placeholder="Enter Username" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Enter Password" required>
            </div>
            <button type="submit" name="login_btn" class="btn btn-primary w-100">Login Now</button>
        </form>
        
        <div class="text-center mt-3">
            <small>Don't have an account? <a href="register.php">Register</a></small>
        </div>
    </div>
</body>
</html>