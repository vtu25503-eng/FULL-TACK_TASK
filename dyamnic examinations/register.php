<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'db.php'; // Make sure this file has your $conn variable

if (isset($_POST['signup_btn'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // 1. Check if username exists
    $check_user = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
    
    // FIXED: Using mysqli_num_rows (no double "num")
    if (mysqli_num_rows($check_user) > 0) {
        $error = "Username already exists! Choose another.";
    } else {
        // 2. Insert new student
        $query = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', 'student')";
        $insert_query_result = mysqli_query($conn, $query);

        if ($insert_query_result) {
            // 3. Log them in automatically
            $new_user_id = mysqli_insert_id($conn);
            
            $_SESSION['user_id'] = $new_user_id;
            $_SESSION['username'] = $username;
            $_SESSION['role'] = 'student';

            // 4. Send them directly to the exam
            header("Location: take_exam.php");
            exit();
        } else {
            $error = "Registration failed. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register Student</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light d-flex align-items-center vh-100">
    <div class="container card shadow-sm p-4" style="max-width: 400px;">
        <h3 class="text-center text-success">Register Student</h3>
        <hr>
        <?php if(isset($error)) echo "<div class='alert alert-warning'>$error</div>"; ?>
        
        <form method="POST">
            <div class="mb-3">
                <label><b>Username</b></label>
                <input type="text" name="username" class="form-control" placeholder="Enter username" required>
            </div>
            <div class="mb-3">
                <label><b>Password</b></label>
                <input type="password" name="password" class="form-control" placeholder="Enter password" required>
            </div>
            <button type="submit" name="signup_btn" class="btn btn-success w-100">Sign Up</button>
        </form>
        <p class="text-center mt-3">Already have an account? <a href="login.php">Login</a></p>
    </div>
</body>
</html>