<?php
// ── apply_careers.php ────────────────────────────────────────
// Handles Careers page job-application submissions:
//   1. Validates input
//   2. Saves uploaded CV into /uploads
//   3. Inserts the record into job_applications (MySQL)
//   4. Emails CAREERS_NOTIFY_EMAILS (via Zoho SMTP / PHPMailer) with the
//      applicant details + a link to the CV, using careers_message.html
// Returns JSON so careers.js can show success / error messages.

header('Content-Type: application/json');
date_default_timezone_set('Asia/Kolkata');

require_once __DIR__ . '/admin_panel/config.php';
require_once __DIR__ . '/mailer.php';

function respond($ok, $message) {
    echo json_encode(['ok' => $ok, 'message' => $message]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    respond(false, 'Invalid request method.');
}

$firstName = trim($_POST['first_name'] ?? '');
$secondName = trim($_POST['second_name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$position = trim($_POST['position'] ?? '');

if ($firstName === '' || $secondName === '' || $email === '' || $position === '') {
    respond(false, 'Please fill in all required fields.');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    respond(false, 'Please enter a valid email address.');
}

if (empty($_FILES['cv']) || $_FILES['cv']['error'] !== UPLOAD_ERR_OK) {
    respond(false, 'Please upload your CV / Resume.');
}

$file = $_FILES['cv'];

// ── Validate file type ──
$allowedExt  = ['pdf', 'doc', 'docx'];
$allowedMime = [
    'application/pdf',
    'application/msword',
    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
];

$origName = $file['name'];
$ext      = strtolower(pathinfo($origName, PATHINFO_EXTENSION));

$finfo    = finfo_open(FILEINFO_MIME_TYPE);
$mimeType = finfo_file($finfo, $file['tmp_name']);
finfo_close($finfo);

if (!in_array($ext, $allowedExt, true) || !in_array($mimeType, $allowedMime, true)) {
    respond(false, 'Only PDF, DOC, DOCX files are allowed.');
}

// ── Validate file size (5MB max) ──
if ($file['size'] > 5 * 1024 * 1024) {
    respond(false, 'File size must be under 5MB.');
}

// ── Move file into /uploads ──
$uploadsDir = __DIR__ . '/uploads';
if (!is_dir($uploadsDir)) {
    mkdir($uploadsDir, 0755, true);
}

$safeName = bin2hex(random_bytes(16)) . '.' . $ext;
$destPath = $uploadsDir . '/' . $safeName;

if (!move_uploaded_file($file['tmp_name'], $destPath)) {
    respond(false, 'Something went wrong while uploading your CV. Please try again.');
}

$cvRelativePath = 'uploads/' . $safeName;   // stored in DB, also used to build admin_applications.php links

// ── Insert into DB ──
try {
    $pdo  = getDB();
    $stmt = $pdo->prepare(
        'INSERT INTO job_applications (first_name, second_name, email, phone, position, cv_path, cv_original_name)
         VALUES (:first_name, :second_name, :email, :phone, :position, :cv_path, :cv_original_name)'
    );
    $stmt->execute([
        ':first_name'       => $firstName,
        ':second_name'      => $secondName ?? null,
        ':email'            => $email,
        ':phone'            => $phone ?: null,
        ':position'         => $position,
        ':cv_path'          => $cvRelativePath,
        ':cv_original_name' => $origName,
    ]);
} catch (Exception $e) {
    // Clean up the uploaded file if the DB insert failed
    if (file_exists($destPath)) unlink($destPath);
    respond(false, 'Something went wrong. Please try again.');
}

// ── Build absolute URL to the saved CV ──
$scheme  = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host    = $_SERVER['HTTP_HOST'] ?? 'localhost';
$baseDir = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/'); // folder apply.php lives in
$cvUrl   = $scheme . '://' . $host . $baseDir . '/' . $cvRelativePath;
$cvSizeKb = round($file['size'] / 1024);

// ── Send notification email (Zoho SMTP via PHPMailer) using careers_message.html ──
$applicantName = trim($firstName . ' ' . $secondName);
$cvNote = $origName . ' (' . $cvSizeKb . ' KB) — Download: ' . $cvUrl;
$time   = date('d M Y, h:i A');

$mailResult = sendNotificationEmail(
    'New Job Application: ' . $applicantName . ' (' . $position . ')',
    __DIR__ . '/careers_message.html',
    [
        'applicant_name'  => $applicantName,
        'applicant_email' => $email,
        'applicant_phone' => $phone ?: 'Not provided',
        'position'        => $position,
        'cv_note'         => $cvNote,
        'time'            => $time,
    ],
    CAREERS_NOTIFY_EMAILS,
    $email,
    $applicantName
);

if (!$mailResult['ok']) {
    // DB + file save already succeeded — log the mail error but still tell the
    // user their application went through (mirrors previous EmailJS behaviour).
    error_log('Careers notification email failed: ' . $mailResult['error']);
}

echo json_encode([
    'ok'         => true,
    'message'    => 'Application submitted successfully!',
    'cv_url'     => $cvUrl,
    'cv_name'    => $origName,
    'cv_size_kb' => $cvSizeKb,
]);
exit;