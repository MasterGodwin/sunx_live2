<?php
// ── applications_api.php ───────────────────────────────────────
// Backend for job_applications: filtered listing (View), delete
// (soft-delete), and saving a response (status + reason).
//
// Included by admin_applications.php on every page load (so the
// two never duplicate the filter/query logic), and also hit
// directly for:
//   - POST action=delete / action=respond   (form submits)
//   - GET  ajax=1                            (live filter refresh)

require_once __DIR__ . '/auth.php';
requireRole(['admin', 'hr']);

$pdo = getDB();
$role = currentRole();
$canRespond = ($role === 'hr');

// Small lookup so we can show "Responded by <name>" without extra joins.
$loginMap = [];
foreach ($pdo->query('SELECT id, username FROM login') as $lu) {
    $loginMap[(int) $lu['id']] = $lu['username'];
}

$toast = '';
$toastErr = false;

// ── Delete (admin only) ──
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'delete' && $role === 'admin') {
    $id = (int) ($_POST['app_id'] ?? 0);
    if ($id > 0) {
        $pdo->prepare('UPDATE job_applications SET deleted_at = 1 WHERE id = :id')
            ->execute([':id' => $id]);
        $toast = 'Application removed.';
    }
    header('Location: admin_applications.php' . ($toast ? '?msg=' . urlencode($toast) : ''));
    exit;
}

// ── Save response (status + reason) — HR only ──
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'respond' && $canRespond) {
    $id = (int) ($_POST['app_id'] ?? 0);
    $status = $_POST['status'] ?? '';
    $reason = trim($_POST['reason'] ?? '');
    $allowedStatus = ['approved', 'inprogress', 'rejected'];

    if ($id > 0 && in_array($status, $allowedStatus, true)) {
        $pdo->prepare(
            'UPDATE job_applications
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
    header('Location: admin_applications.php' . ($toast ? '?msg=' . urlencode($toast) . ($toastErr ? '&err=1' : '') : ''));
    exit;
}

if (!empty($_GET['msg'])) {
    $toast = htmlspecialchars($_GET['msg']);
    $toastErr = !empty($_GET['err']);
}

// ── View / List (filters) ──
$today = date('Y-m-d');
$search = trim($_GET['search'] ?? '');
$dateFrom = trim($_GET['date_from'] ?? $today);
$dateTo = trim($_GET['date_to'] ?? $today);
$position = trim($_GET['position'] ?? '');

$positions = $pdo->query(
    'SELECT DISTINCT position FROM job_applications WHERE deleted_at = 0 ORDER BY position ASC'
)->fetchAll(PDO::FETCH_COLUMN);

$where = ['a.deleted_at = 0'];
$params = [];

if ($search !== '') {
    $where[] = '(a.name LIKE :s OR a.email LIKE :s2 OR a.phone LIKE :s3)';
    $params[':s'] = '%' . $search . '%';
    $params[':s2'] = '%' . $search . '%';
    $params[':s3'] = '%' . $search . '%';
}
if ($position !== '') {
    $where[] = 'a.position = :pos';
    $params[':pos'] = $position;
}
if ($dateFrom !== '') {
    $where[] = 'DATE(a.created_at) >= :df';
    $params[':df'] = $dateFrom;
}
if ($dateTo !== '') {
    $where[] = 'DATE(a.created_at) <= :dt';
    $params[':dt'] = $dateTo;
}

$sql = 'SELECT a.* FROM job_applications a WHERE ' . implode(' AND ', $where) . ' ORDER BY a.created_at DESC';
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$applications = $stmt->fetchAll();

$totalApps = $pdo->query('SELECT COUNT(*) FROM job_applications WHERE deleted_at = 0')->fetchColumn();
$filteredCount = count($applications);
$isFiltered = ($search !== '' || $position !== '' || $dateFrom !== $today || $dateTo !== $today);

// ── AJAX partial request (filter/search without changing URL) ──
if (($_GET['ajax'] ?? '') === '1') {
    include __DIR__ . '/applications_table.php';
    exit;
}
