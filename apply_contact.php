<?php
header('Content-Type: application/json');
date_default_timezone_set('Asia/Kolkata');
require_once __DIR__ . '/admin_panel/config.php';
require_once __DIR__ . '/mailer.php';

function respond(bool $ok, string $message): void {
    echo json_encode(['ok' => $ok, 'message' => $message]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    respond(false, 'Invalid request method.');
}

$type         = trim($_POST['type'] ?? 'individual');
$type         = ($type === 'company') ? 'company' : 'individual';

$first_name   = trim($_POST['first_name']   ?? '');
$second_name  = trim($_POST['second_name']  ?? '');
$company_name = trim($_POST['company_name'] ?? '');
$email        = trim($_POST['email']        ?? '');
$phone_number = trim($_POST['phone_number'] ?? '');
$message      = trim($_POST['message']      ?? '');
$services     = trim($_POST['services']     ?? '');

// ── Validation (type-aware) ──
if ($type === 'company') {
    // Company mode: second_name is intentionally empty, company_name required instead
    if ($company_name === '' || $email === '' || $message === '') {
        respond(false, 'Please fill in Company Name, Email and Message.');
    }
    // Store company name in first_name so admin panel/listing keeps working unchanged
    $first_name  = $company_name;
    $second_name = '';
} else {
    // Individual mode
    if ($first_name === '' || $second_name === '' || $email === '' || $message === '') {
        respond(false, 'Please fill in all required fields.');
    }
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    respond(false, 'Please enter a valid email address.');
}

// ── Insert into DB ──
try {
    $pdo  = getDB();
    $stmt = $pdo->prepare(
        'INSERT INTO leads
           (first_name, second_name, company_name, email, phone_number, message, services, type)
         VALUES
           (:fn, :sn, :cn, :em, :ph, :msg, :sv, :ty)'
    );
    $stmt->execute([
        ':fn'  => $first_name,
        ':sn'  => $second_name,
        ':cn'  => $company_name,
        ':em'  => $email,
        ':ph'  => $phone_number,
        ':msg' => $message,
        ':sv'  => $services,
        ':ty'  => $type,
    ]);
} catch (Exception $e) {
    respond(false, 'Something went wrong. Please try again.');
}

// ── Send notification email (Zoho SMTP via PHPMailer) using contact_message.html ──
$displayName = ($type === 'company') ? $first_name : trim($first_name . ' ' . $second_name);
$time = date('d M Y, h:i A');

$mailResult = sendNotificationEmail(
    'New Enquiry: ' . $displayName,
    __DIR__ . '/contact_message.html',
    [
        'type'     => ($type === 'company') ? 'Company' : 'Individual',
        'name'     => $displayName,
        'email'    => $email,
        'phone'    => $phone_number ?: 'Not provided',
        'services' => $services ?: 'None selected',
        'message'  => $message,
        'time'     => $time,
    ],
    CONTACT_NOTIFY_EMAILS,
    $email,
    $displayName
);

if (!$mailResult['ok']) {
    // DB save already succeeded — log the mail error but still tell the user
    // their enquiry went through (mirrors previous EmailJS behaviour).
    error_log('Contact notification email failed: ' . $mailResult['error']);
}

// ── Success ──
echo json_encode([
    'ok'      => true,
    'message' => 'Form submitted successfully!',
]);
exit;