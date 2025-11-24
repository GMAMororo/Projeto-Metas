<?php
// delete_event.php - exclui evento por id
header('Content-Type: application/json; charset=utf-8');
require_once 'conexao.php';

$id = $_POST['id'] ?? $_GET['id'] ?? null;
if (!$id) {
    http_response_code(400);
    echo json_encode(['status'=>'error','message'=>'id required']);
    exit;
}

try {
    $stmt = $pdo->prepare("DELETE FROM events WHERE id = :id");
    $stmt->execute([':id' => $id]);
    echo json_encode(['status'=>'success']);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['status'=>'error','message'=>$e->getMessage()]);
}
?>
