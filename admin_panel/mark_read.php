<?php
require_once __DIR__ . '/auth.php';

header('Content-Type: application/json');

if (empty($_SESSION['sunx_admin_auth'])) {
    http_response_code(403);
    echo json_encode(['ok' => false]);
    exit;
}

$allowedTables = ['job_applications', 'leads'];
$table = $_POST['table'] ?? '';
$id    = (int)($_POST['id'] ?? 0);

if ($id <= 0 || !in_array($table, $allowedTables, true)) {
    echo json_encode(['ok' => false, 'message' => 'Invalid request.']);
    exit;
}

try {
    $pdo = getDB();
    $pdo->prepare("UPDATE `{$table}` SET `new` = 1 WHERE id = :id")
        ->execute([':id' => $id]);
    echo json_encode(['ok' => true]);
} catch (Exception $e) {
    echo json_encode(['ok' => false]);
}
