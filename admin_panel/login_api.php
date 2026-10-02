<?php
// ── login_api.php ──────────────────────────────────────────────
// Handles: POST (login form submit) and ?action=logout
// This is the single place that touches the `login` table for
// credential checks, so index.php stays purely presentational.

require_once __DIR__ . '/auth.php';

// ── Logout ──
if (($_GET['action'] ?? '') === 'logout') {
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $p = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
    }
    session_destroy();

    header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
    header('Pragma: no-cache');
    header('Expires: Thu, 01 Jan 1970 00:00:00 GMT');
    header('Location: index.php');
    exit;
}

// ── Login ──
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $loginTab = ($_POST['login_tab'] ?? 'admin') === 'user' ? 'user' : 'admin';
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    $redirectBack = function (string $error) use ($username, $loginTab) {
        $qs = http_build_query([
            'error' => $error,
            'tab'   => $loginTab,
            'u'     => $username,
        ]);
        header('Location: index.php?' . $qs);
        exit;
    };

    if ($username === '' || $password === '') {
        $redirectBack('Please enter both username and password.');
    }

    $pdo = getDB();
    $stmt = $pdo->prepare(
        'SELECT id, password, role FROM login
                WHERE username = :u AND deleted_at = 0
                LIMIT 1'
    );
    $stmt->execute([':u' => $username]);
    $row = $stmt->fetch();

    if (!$row || !password_verify($password, $row['password'])) {
        $redirectBack('Invalid username or password. Try again.');
    }

    $role = $row['role'] ?? 'admin';

    // Admin tab may only sign in as admin; User tab may only sign in as hr/sales.
    $tabMatchesRole = ($loginTab === 'admin' && $role === 'admin')
                   || ($loginTab === 'user' && in_array($role, ['hr', 'sales'], true));

    if (!$tabMatchesRole) {
        $redirectBack('Please use the correct login tab for this account.');
    }

    session_regenerate_id(true);
    $_SESSION['sunx_admin_auth']     = true;
    $_SESSION['sunx_admin_id']       = $row['id'];
    $_SESSION['sunx_admin_role']     = $role;
    $_SESSION['sunx_last_activity']  = time(); // starts the 1-hour session clock

    header('Location: ' . roleHome($role));
    exit;
}

// Any other request type — nothing to do here.
header('Location: index.php');
exit;
