<?php
// events.php - retorna eventos em JSON a partir da tabela genérica 'events'
header('Content-Type: application/json; charset=utf-8');
require_once 'conexao.php';

try {
    $stmt = $pdo->query("SELECT id, title, description, start, `end` FROM events ORDER BY start");
    $events = $stmt->fetchAll();
    echo json_encode($events);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
