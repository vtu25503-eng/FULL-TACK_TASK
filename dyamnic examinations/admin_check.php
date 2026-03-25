<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. Check if user is logged in
// 2. Check if their role is actually 'admin'
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    // If they aren't an admin, kick them back to the login or student dashboard
    header("Location: login.php?error=unauthorized");
    exit();
}
?>