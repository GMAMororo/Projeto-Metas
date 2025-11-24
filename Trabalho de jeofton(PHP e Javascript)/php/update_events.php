<?php
// update_event.php - atualiza título/descrição/datas (ou apenas datas para drag & resize)
header('Content-Type: application/json; charset=utf-8');
require_once 'conexao.php';

$id = $_POST['id'] ?? null;
$title = $_POST['title'] ?? $_POST['titulo'] ?? null;
$description = $_POST['description'] ?? $_POST['descricao'] ?? null;
$start = $_POST['start'] ?? $_POST['data_inicio'] ?? null;
$end = $_POST['end'] ?? $_POST['data_fim'] ?? null;

if (!$id) {
    http_response_code(400);
    echo json_encode(['status'=>'error','message'=>'id required']);
    exit;
}

try {
    // Build dynamic query depending on provided fields
    $fields = [];
    $params = [':id' => $id];
    if ($title !== null) { $fields[] = 'title = :title'; $params[':title'] = $title; }
    if ($description !== null) { $fields[] = 'description = :description'; $params[':description'] = $description; }
    if ($start !== null) { $fields[] = 'start = :start'; $params[':start'] = $start; }
    if ($end !== null) { $fields[] = '`end` = :end'; $params[':end'] = $end; }

    if (empty($fields)) {
        echo json_encode(['status'=>'noop','message'=>'nothing to update']);
        exit;
    }

    $sql = "UPDATE events SET " . implode(', ', $fields) . " WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    echo json_encode(['status'=>'success']);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['status'=>'error','message'=>$e->getMessage()]);
}
?>
