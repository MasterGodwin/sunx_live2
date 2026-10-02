<?php
// ── hash_existing_passwords.php ────────────────────────────────
// ONE-TIME MIGRATION SCRIPT — not part of the app structure.
//
// Your `login` table currently stores plaintext passwords
// (e.g. 'admin@123'). Run this ONCE from the browser or CLI to
// convert every plaintext password to a bcrypt hash via PHP's
// password_hash(), so login_api.php's password_verify() works.
//
// HOW TO USE:
//   1. Upload this file next to config.php on the server.
//   2. Visit it once in the browser (or `php hash_existing_passwords.php`).
//   3. Confirm the "done" output listing each user that was updated.
//   4. DELETE this file from the server immediately afterward.
//
// It is safe to run more than once — already-hashed passwords
// (they start with $2y$) are skipped automatically.

require_once __DIR__ . '/config.php';

$pdo = getDB();
$rows = $pdo->query('SELECT id, username, password FROM login')->fetchAll();

$updated = [];
$skipped = [];

foreach ($rows as $row) {
    $pw = $row['password'];

    // Already a bcrypt hash? Skip it.
    if (preg_match('/^\$2y\$/', $pw)) {
        $skipped[] = $row['username'];
        continue;
    }

    $hash = password_hash($pw, PASSWORD_DEFAULT);
    $pdo->prepare('UPDATE login SET password = :p WHERE id = :id')
        ->execute([':p' => $hash, ':id' => $row['id']]);
    $updated[] = $row['username'];
}

header('Content-Type: text/plain');
echo "Password migration complete.\n\n";
echo "Hashed (" . count($updated) . "): " . (implode(', ', $updated) ?: '(none)') . "\n";
echo "Already hashed / skipped (" . count($skipped) . "): " . (implode(', ', $skipped) ?: '(none)') . "\n\n";
echo "IMPORTANT: delete this file from the server now.\n";
