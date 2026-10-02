<?php
// ── auth.php ───────────────────────────────────────────────────
// Session bootstrap + authentication/authorization helpers.
// Every protected page should require_once this file (instead of
// calling session_start()/config.php directly).
//
// Also acts as a lightweight JSON endpoint when hit directly, e.g.
//   fetch('auth.php?action=check')
// so navbar.php's back-button guard has something to call
// (this replaces the old standalone check_auth.php).

require_once __DIR__ . '/config.php';

const SESSION_LIFETIME = 3600; // 1 hour, in seconds

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// ── Enforce a 1-hour idle session timeout ──
// Called from requireAuth() so it only applies to protected pages.
function enforceSessionTimeout(): void {
    if (!empty($_SESSION['sunx_admin_auth'])) {
        $lastActivity = $_SESSION['sunx_last_activity'] ?? null;
        if ($lastActivity !== null && (time() - $lastActivity) > SESSION_LIFETIME) {
            $_SESSION = [];
            if (ini_get('session.use_cookies')) {
                $p = session_get_cookie_params();
                setcookie(session_name(), '', time() - 42000, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
            }
            session_destroy();
            header('Location: index.php?timeout=1');
            exit;
        }
        // Sliding expiry — any activity on a protected page resets the clock.
        $_SESSION['sunx_last_activity'] = time();
    }
}

function requireAuth(): void {
    header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
    header('Pragma: no-cache');
    header('Expires: Thu, 01 Jan 1970 00:00:00 GMT');

    if (empty($_SESSION['sunx_admin_auth'])) {
        header('Location: index.php');
        exit;
    }
    enforceSessionTimeout();
}

// ── Returns the logged-in user's role: 'admin' | 'hr' | 'sales' ──
function currentRole(): string {
    return $_SESSION['sunx_admin_role'] ?? 'admin';
}

// ── The default landing page for each role ──
function roleHome(string $role): string {
    switch ($role) {
        case 'hr':    return 'admin_applications.php';
        case 'sales': return 'sales_messages.php';
        default:      return 'admin_dashboard.php';
    }
}

// ── Require auth AND that the user's role is one of $roles ──
// Example: requireRole(['admin', 'hr']);
function requireRole(array $roles): void {
    requireAuth();
    $role = currentRole();
    if (!in_array($role, $roles, true)) {
        header('Location: ' . roleHome($role));
        exit;
    }
}

// ── Convenience helper used by several pages to show the signed-in user's name ──
function currentUsername(PDO $pdo, string $default = 'Admin'): string {
    if (empty($_SESSION['sunx_admin_id'])) {
        return $default;
    }
    $stmt = $pdo->prepare('SELECT username FROM login WHERE id = :id');
    $stmt->execute([':id' => $_SESSION['sunx_admin_id']]);
    $row = $stmt->fetch();
    return $row['username'] ?? $default;
}

// ── Direct-hit endpoint mode: GET auth.php?action=check ──
// Returns JSON. Only runs when this file is the entry point (not included).
if (basename($_SERVER['SCRIPT_FILENAME']) === basename(__FILE__)) {
    header('Content-Type: application/json');
    header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
    header('Pragma: no-cache');

    $action = $_GET['action'] ?? $_POST['action'] ?? 'check';

    if ($action === 'check') {
        // NOTE: does not call enforceSessionTimeout()'s redirect behaviour here —
        // a JSON endpoint shouldn't issue a Location redirect. Just report status.
        $ok = !empty($_SESSION['sunx_admin_auth']);
        if ($ok) {
            $lastActivity = $_SESSION['sunx_last_activity'] ?? time();
            if ((time() - $lastActivity) > SESSION_LIFETIME) {
                $ok = false;
            } else {
                $_SESSION['sunx_last_activity'] = time();
            }
        }
        echo json_encode(['ok' => $ok]);
        exit;
    }

    echo json_encode(['ok' => false, 'message' => 'Unknown action.']);
    exit;
}
