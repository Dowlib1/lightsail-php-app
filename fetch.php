<?php
// fetch.php - returns JSON list of messages from the `messages` table
header('Content-Type: application/json');

require_once __DIR__ . '/db.php';

try {
    $pdo = getPDO();
    $stmt = $pdo->query('SELECT id, text FROM messages ORDER BY id ASC LIMIT 100');
    $messages = $stmt->fetchAll();
    echo json_encode(['messages' => $messages]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Query failed: ' . $e->getMessage()]);
}