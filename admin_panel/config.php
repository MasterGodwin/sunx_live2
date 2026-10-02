<?php

// India Timezone
date_default_timezone_set('Asia/Kolkata');

define('DB_HOST', 'localhost');
define('DB_NAME', 'sunx_website');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

function getDB(): PDO {
    static $pdo = null;

    if ($pdo === null) {
        $dsn = 'mysql:host=' . DB_HOST
             . ';dbname=' . DB_NAME
             . ';charset=' . DB_CHARSET;

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);

            // MySQL timezone to IST
            $pdo->exec("SET time_zone = '+05:30'");

        } catch (PDOException $e) {
            http_response_code(500);
            die('Database connection failed.');
        }
    }

    return $pdo;
}

// NOTE: Session/auth helpers (requireAuth, requireRole, currentRole, roleHome)
// now live in auth.php, since they need session_start() + timeout handling.
// config.php stays focused on the DB connection only.