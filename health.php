<?php
header('Content-Type: application/json');

// Check database connection
$status = 'healthy';
$message = 'PHP Docker app running with secure DB credentials via environment variables';
try {
    require_once __DIR__ . '/db.php';
    $pdo = require __DIR__ . '/db.php';
    $stmt = $pdo->query('SELECT 1');
    if (!$stmt->fetchColumn()) {
        throw new Exception('DB query failed');
    }
} catch (Exception $e) {
    $status = 'unhealthy';
    $message = 'Database connection failed: ' . $e->getMessage();
}

echo json_encode([
    'status' => $status,
    'app' => 'Oladimeji-NOUN-2026',
    'message' => $message,
    'timestamp' => date('Y-m-d H:i:s')
]);
?>