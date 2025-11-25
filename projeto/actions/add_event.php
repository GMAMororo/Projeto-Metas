<?php
// add_event.php
session_start();
if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    exit("Acesso negado.");
}
$current_user_id = $_SESSION['user_id'];
require '../config/conexao.php';

// Pega e sanitiza os dados (mysqli_real_escape_string é crucial, mesmo para demo)
$title = $conexao->real_escape_string($_POST['title'] ?? '');
$description = $conexao->real_escape_string($_POST['description'] ?? '');
$start = $conexao->real_escape_string($_POST['start'] ?? '');
$end = $conexao->real_escape_string($_POST['end'] ?? '');

if (empty($title) || empty($start)) {
    http_response_code(400);
    exit("Título e Início são obrigatórios.");
}

// Trata o campo 'end' se estiver vazio
$end_value = empty($end) ? 'NULL' : "'$end'";

// Insere o user_id junto com o evento
$sql = "INSERT INTO events (title, description, start, end, user_id) 
        VALUES ('$title', '$description', '$start', $end_value, $current_user_id)";

if ($conexao->query($sql)) {
    echo json_encode(['success' => true, 'id' => $conexao->insert_id]);
} else {
    http_response_code(500);
    echo "Erro ao salvar o evento: " . $conexao->error;
}

$conexao->close();
?>