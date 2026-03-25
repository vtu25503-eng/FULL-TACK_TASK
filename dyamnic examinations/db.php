<?php
// 1. Error Reporting (Keep this during development)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 2. Database Credentials
$host = "localhost";
$user = "root";
$pass = "";
$db   = "online_exams"; 

// 3. Establish Connection
$conn = new mysqli($host, $user, $pass, $db);

// 4. Check Connection
if ($conn->connect_error) {
    // In a real site, we don't show specific errors to users, but for now, this is helpful:
    die("Database Connection failed: " . $conn->connect_error);
}

// 5. Set Charset (Important for supporting special characters/names)
$conn->set_charset("utf8mb4");

// Note: We removed the "Echo" so it doesn't mess up your website's layout.
?>