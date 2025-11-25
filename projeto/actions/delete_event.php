<?php
// delete_event.php
session_start();
if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    exit("Acesso negado.");
}
$current_user_id = $_SESSION['user_id'];
require '../config/conexao.php';

if (!isset($_POST['id'])) {
    http_response_code(400);
    exit("ID do evento não fornecido.");
}

$id = (int)$_POST['id'];

// CRUCIAL: Deleta APENAS se o evento pertencer ao usuário logado
$sql = "DELETE FROM events WHERE id = $id AND user_id = $current_user_id";

if ($conexao->query($sql)) {
    if ($conexao->affected_rows > 0) {
        echo json_encode(['success' => true]);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Evento não encontrado ou acesso negado.']);
    }
} else {
    http_response_code(500);
    echo "Erro ao deletar o evento: " . $conexao->error;
}

$conexao->close();
?>