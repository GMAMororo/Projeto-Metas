<?php
// events.php
session_start();
// Proteção de acesso
if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    exit(json_encode(['error' => 'Acesso negado.']));
}
$current_user_id = $_SESSION['user_id'];
// Usa a conexão criada em conexao.php
require 'conexao.php';

// Filtra APENAS pelos eventos do usuário logado
$sql = "SELECT id, title, description, start, end FROM events WHERE user_id = $current_user_id ORDER BY start";
$result = $conexao->query($sql);

$events = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($events);

$conexao->close();
?>