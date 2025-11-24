<?php
// add_event.php - insere evento e retorna id
header('Content-Type: application/json; charset=utf-8');
require_once 'conexao.php';

$title = $_POST['title'] ?? $_POST['titulo'] ?? '';
$description = $_POST['description'] ?? $_POST['descricao'] ?? '';
$start = $_POST['start'] ?? $_POST['data_inicio'] ?? '';
$end = $_POST['end'] ?? $_POST['data_fim'] ?? '';

if (!$title || !$start) {
    http_response_code(400);
    echo json_encode(['status'=>'error','message'=>'title and start required']);
    exit;
}

try {
    $stmt = $pdo->prepare("INSERT INTO events (title, description, start, `end`) VALUES (:title, :description, :start, :end)");
    $stmt->execute([
        ':title' => $title,
        ':description' => $description,
        ':start' => $start,
        ':end' => $end ?: null
    ]);
    $id = $pdo->lastInsertId();
    echo json_encode(['status'=>'success','id'=>$id]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['status'=>'error','message'=>$e->getMessage()]);
}
?>

