<?php
// db.php - Secure database connection using environment variables

$host     = getenv('DB_HOST');
$dbname   = getenv('DB_NAME');
$username = getenv('DB_USER');
$password = getenv('DB_PASSWORD');

if (!$host || !$dbname || !$username || !$password) {
    die("Database configuration missing. Please set environment variables.");
}

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
} catch (PDOException $e) {
    // In production, do NOT show detailed error to users
    error_log("Database connection failed: " . $e->getMessage());
    die("Database connection error. Please try again later.");
}

return $pdo;   // Return the connection so other files can use it
?>