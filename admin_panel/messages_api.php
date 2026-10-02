<?php
// ── messages_api.php ───────────────────────────────────────────
// Backend for the `leads` table (contact form messages). Shared by
// two frontends: sales_messages.php (Sales — can respond) and
// admin_dashboard.php (Admin — view/delete only, read-only response).
//
// Included by both pages on every load; also hit directly for
// POST action=new_message / delete / respond, and GET ajax=1.

require_once __DIR__ . '/auth.php';
requireRole(['admin', 'sales']);

$pdo = getDB();
$role = currentRole();
$canRespond = ($role === 'sales');
$returnPage = ($role === 'sales') ? 'sales_messages.php' : 'admin_dashboard.php';

// Small lookup so we can show "Responded by <name>" without extra joins.
$loginMap = [];
foreach ($pdo->query('SELECT id, username FROM login') as $lu) {
    $loginMap[(int) $lu['id']] = $lu['username'];
}

$toast = '';
$toastErr = false;

// ── Mark as read (opened) ──
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'new_message') {
    $id = (int) ($_POST['lead_id'] ?? 0);
    if ($id > 0) {
        $pdo->prepare('UPDATE leads SET `new` = 1 WHERE id = :id')
            ->execute([':id' => $id]);
    }
    header('Location: ' . $returnPage);
    exit;
}

// ── Soft delete ──
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'delete') {
    $id = (int) ($_POST['lead_id'] ?? 0);
    if ($id > 0) {
        $pdo->prepare('UPDATE leads SET deleted_at = 1 WHERE id = :id')
            ->execute([':id' => $id]);
        $toast = 'Message removed.';
    }
    header('Location: ' . $returnPage . ($toast ? '?msg=' . urlencode($toast) : ''));
    exit;
}

// ── Save response (status + reason) — Sales only ──
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'respond' && $canRespond) {
    $id = (int) ($_POST['lead_id'] ?? 0);
    $status = $_POST['status'] ?? '';
    $reason = trim($_POST['reason'] ?? '');
    $allowedStatus = ['approved', 'inprogress', 'rejected'];

    if ($id > 0 && in_array($status, $allowedStatus, true)) {
        $pdo->prepare(
            'UPDATE leads
                SET status = :st, response_reason = :r, responded_by = :rb, responded_at = NOW(), `new` = 1
              WHERE id = :id'
        )->execute([
            ':st' => $status,
            ':r'  => $reason,
            ':rb' => $_SESSION['sunx_admin_id'],
            ':id' => $id,
        ]);
        $toast = 'Response saved.';
    } else {
        $toast = 'Please choose a status before saving.';
        $toastErr = true;
    }
    header('Location: ' . $returnPage . ($toast ? '?msg=' . urlencode($toast) . ($toastErr ? '&err=1' : '') : ''));
    exit;
}

if (!empty($_GET['msg'])) {
    $toast = htmlspecialchars($_GET['msg']);
    $toastErr = !empty($_GET['err']);
}

// ── View / List (filters — default to today if no date passed) ──
$today = date('Y-m-d');
$search = trim($_GET['search'] ?? '');
$dateFrom = trim($_GET['date_from'] ?? $today);
$dateTo = trim($_GET['date_to'] ?? $today);
$type = trim($_GET['type'] ?? '');

$where = ['deleted_at = 0'];
$params = [];

if ($search !== '') {
    $where[] = '(first_name LIKE :s OR second_name LIKE :s2 OR email LIKE :s3 OR phone_number LIKE :s4 OR company_name LIKE :s5)';
    $params[':s'] = '%' . $search . '%';
    $params[':s2'] = '%' . $search . '%';
    $params[':s3'] = '%' . $search . '%';
    $params[':s4'] = '%' . $search . '%';
    $params[':s5'] = '%' . $search . '%';
}
if ($dateFrom !== '') {
    $where[] = 'DATE(created_at) >= :df';
    $params[':df'] = $dateFrom;
}
if ($dateTo !== '') {
    $where[] = 'DATE(created_at) <= :dt';
    $params[':dt'] = $dateTo;
}
if ($type === 'individual' || $type === 'company') {
    $where[] = 'type = :ty';
    $params[':ty'] = $type;
}

$sql = 'SELECT * FROM leads WHERE ' . implode(' AND ', $where) . ' ORDER BY created_at DESC';
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$leads = $stmt->fetchAll();

$totalLeads = $pdo->query('SELECT COUNT(*) FROM leads WHERE deleted_at = 0')->fetchColumn();
$filteredCount = count($leads);
$isFiltered = ($search !== '' || $dateFrom !== $today || $dateTo !== $today || $type !== '');

// ── AJAX partial request ──
if (($_GET['ajax'] ?? '') === '1') {
    include __DIR__ . '/leads_table.php';
    exit;
}
