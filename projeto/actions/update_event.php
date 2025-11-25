<?php
// update_event.php
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
$sql_parts = [];

// Funções utilitárias para sanitizar e adicionar à lista de updates
function get_update_part($conexao, $key, $value) {
    if (isset($_POST[$key]) && $_POST[$key] !== null) {
        $escaped_value = $conexao->real_escape_string($value);
        if ($key === 'end' && empty($escaped_value)) {
            return "`end` = NULL";
        }
        return "`$key` = '$escaped_value'";
    }
    return null;
}

$sql_parts[] = get_update_part($conexao, 'title', $_POST['title'] ?? null);
$sql_parts[] = get_update_part($conexao, 'description', $_POST['description'] ?? null);
$sql_parts[] = get_update_part($conexao, 'start', $_POST['start'] ?? null);
$sql_parts[] = get_update_part($conexao, 'end', $_POST['end'] ?? null);

// Filtra valores nulos
$updates = array_filter($sql_parts);

if (empty($updates)) {
    http_response_code(400);
    exit("Nenhum dado para atualizar.");
}

// CRUCIAL: Atualiza apenas se o ID e o USER_ID baterem
$sql = "UPDATE events SET " . implode(', ', $updates) . " WHERE id = $id AND user_id = $current_user_id";

if ($conexao->query($sql)) {
    echo json_encode(['success' => true]);
} else {
    http_response_code(500);
    echo "Erro ao atualizar o evento: " . $conexao->error;
}

$conexao->close();
?>