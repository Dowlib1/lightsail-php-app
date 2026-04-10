<?php
// health.php - health check endpoint
header('Content-Type: application/json');

$ok = true;
$time = date(DATE_ATOM);

// Optionally do a lightweight DB check (comment out if not desired)
// require_once __DIR__ . '/db.php';
// try {
//   $pdo = getPDO();
//   $stmt = $pdo->query('SELECT 1');
//   $ok = (bool)$stmt->fetchColumn();
// } catch (Exception $e) {
//   $ok = false;
// }

http_response_code($ok ? 200 : 503);
echo json_encode([
  'status' => $ok ? 'ok' : 'unhealthy',
  'time' => $time
]);