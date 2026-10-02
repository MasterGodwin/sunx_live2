<?php
// ── roles_api.php ──────────────────────────────────────────────
// Backend for the `jobs` table (job openings shown on the careers
// page): save (create/update), delete, and filtered listing.
// Included by admin_roles.php on every page load; also hit
// directly for POST action=save / action=delete.

require_once __DIR__ . '/auth.php';
requireRole(['admin', 'hr']);

$pdo = getDB();

$typeMap = [1 => 'Full Time', 2 => 'Part Time', 3 => 'Contract', 4 => 'Internship'];
$countryMap = [1 => 'India', 2 => 'Dubai'];
$statusMap = [1 => 'Hiring Now', 2 => 'In Active'];

$toast = '';
$toastErr = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'save') {
        $id = (int) ($_POST['job_id'] ?? 0);
        $title = trim($_POST['fTitle'] ?? '');
        $type = (int) ($_POST['fType'] ?? 1);
        $country = (int) ($_POST['fcountry'] ?? 1);
        $loc = trim($_POST['fLocation'] ?? '');
        $exp = trim($_POST['fExp'] ?? '');
        $stat = (int) ($_POST['fStatus'] ?? 1);
        $desc = trim($_POST['fDesc'] ?? '');

        if ($title === '' || $desc === '') {
            $toast = 'Job title and description are required.';
            $toastErr = true;
        } else {
            if ($id > 0) {
                $stmt = $pdo->prepare(
                    'UPDATE jobs
                        SET job_title = :t, employment_type = :et, country = :c, location = :l,
                            experience_required = :e, status = :s, job_description = :d
                      WHERE id = :id AND deleted_at = 0'
                );
                $stmt->execute([
                    ':t' => $title,
                    ':et' => $type,
                    ':c' => $country,
                    ':l' => $loc,
                    ':e' => $exp,
                    ':s' => $stat,
                    ':d' => $desc,
                    ':id' => $id
                ]);
                $toast = 'Role updated successfully.';
            } else {
                $stmt = $pdo->prepare(
                    'INSERT INTO jobs
                       (job_title, employment_type, country, location, experience_required, status, job_description)
                     VALUES (:t, :et, :c, :l, :e, :s, :d)'
                );
                $stmt->execute([
                    ':t' => $title,
                    ':et' => $type,
                    ':c' => $country,
                    ':l' => $loc,
                    ':e' => $exp,
                    ':s' => $stat,
                    ':d' => $desc
                ]);
                $toast = 'New role added to careers page.';
            }
        }

    } elseif ($action === 'delete') {
        $id = (int) ($_POST['job_id'] ?? 0);
        if ($id > 0) {
            $stmt = $pdo->prepare('UPDATE jobs SET deleted_at = 1 WHERE id = :id');
            $stmt->execute([':id' => $id]);
            $toast = 'Role removed.';
        }
    }

    $qs = $toast ? '?msg=' . urlencode($toast) . ($toastErr ? '&err=1' : '') : '';
    header('Location: admin_roles.php' . $qs);
    exit;
}

if (!empty($_GET['msg'])) {
    $toast = htmlspecialchars($_GET['msg']);
    $toastErr = !empty($_GET['err']);
}

// ── View / Search filter ──
$search = trim($_GET['search'] ?? '');

if ($search !== '') {
    $stmt = $pdo->prepare(
        'SELECT * FROM jobs WHERE deleted_at = 0
          AND (job_title LIKE :s OR location LIKE :s2 OR experience_required LIKE :s3)
         ORDER BY id ASC'
    );
    $stmt->execute([':s' => '%' . $search . '%', ':s2' => '%' . $search . '%', ':s3' => '%' . $search . '%']);
    $jobs = $stmt->fetchAll();
} else {
    $jobs = $pdo->query(
        'SELECT * FROM jobs WHERE deleted_at = 0 ORDER BY id ASC'
    )->fetchAll();
}

$totalJobs = $pdo->query('SELECT COUNT(*) FROM jobs WHERE deleted_at = 0')->fetchColumn();
$fullTimeJobs = count(array_filter($jobs, fn($j) => (int) $j['employment_type'] === 1));
$hiringJobs = count(array_filter($jobs, fn($j) => (int) $j['status'] === 1));
