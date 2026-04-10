name=db.php
<?php
// db.php - reads DB credentials from environment variables (safer for containerized apps)

$DB_HOST = getenv('DB_HOST') ?: '127.0.0.1';
$DB_PORT = getenv('DB_PORT') ?: 3306;
$DB_NAME = getenv('DB_NAME') ?: 'YourName_ApplicationName_2026';
$DB_USER = getenv('DB_USER') ?: 'dbusername';
$DB_PASS = getenv('DB_PASS') ?: 'dbpassword';

function getPDO() {
    global $DB_HOST, $DB_PORT, $DB_NAME, $DB_USER, $DB_PASS;
    static $pdo = null;
    if ($pdo) return $pdo;
    $dsn = "mysql:host={$DB_HOST};port={$DB_PORT};dbname={$DB_NAME};charset=utf8mb4";
    try {
        $pdo = new PDO($dsn, $DB_USER, $DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
        return $pdo;
    } catch (PDOException $e) {
        http_response_code(500);
        header('Content-Type: application/json');
        echo json_encode(['error' => 'DB Connection failed: ' . $e->getMessage()]);
        exit;
    }
}