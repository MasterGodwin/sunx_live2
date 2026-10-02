<?php
// ── mailer.php ───────────────────────────────────────────────
// Shared helper used by apply_careers.php and apply_contact.php
// to send the notification email via Zoho SMTP (PHPMailer),
// using the existing careers_message.html / contact_message.html
// templates as the email body.

require_once __DIR__ . '/mail_config.php';

// ── PHPMailer ──
// Adjust these three paths ONLY IF your PHPMailer folder is named
// differently or sits somewhere else. If you installed it with
// Composer instead, delete these 3 lines and use:
//   require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/PHPMailer/src/Exception.php';
require_once __DIR__ . '/PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * Load an HTML template and replace {{placeholder}} tokens.
 *
 * @param string $templateFile absolute path to the .html template
 * @param array  $data         ['placeholder_name' => 'value', ...]
 * @return string              final HTML body
 */
function renderTemplate(string $templateFile, array $data): string {
    $html = file_get_contents($templateFile);
    if ($html === false) {
        throw new Exception("Template not found: $templateFile");
    }
    foreach ($data as $key => $value) {
        $safe = htmlspecialchars((string)$value, ENT_QUOTES);
        $safe = nl2br($safe); // preserve line breaks in fields like the contact message
        $html = str_replace('{{' . $key . '}}', $safe, $html);
    }
    return $html;
}

/**
 * Send a notification email via Zoho SMTP using a rendered template.
 *
 * @param string $subject
 * @param string $templateFile absolute path to the html template
 * @param array  $placeholders values for {{tokens}} inside the template
 * @param array|string $recipients one email or an array of emails to send TO
 * @param string|null $replyTo optional reply-to (e.g. the applicant's email)
 * @param string|null $replyToName
 * @return array ['ok' => bool, 'error' => string|null]
 */
function sendNotificationEmail(
    string $subject,
    string $templateFile,
    array $placeholders,
    $recipients,
    ?string $replyTo = null,
    ?string $replyToName = null
): array {
    $mail = new PHPMailer(true);
    try {
        // ── Server settings ──
        $mail->isSMTP();
        $mail->Host       = ZOHO_SMTP_HOST;
        $mail->SMTPAuth   = true;
        $mail->Username   = ZOHO_SMTP_USER;
        $mail->Password   = ZOHO_SMTP_PASS;
        $mail->SMTPSecure = ZOHO_SMTP_SECURE === 'ssl' ? PHPMailer::ENCRYPTION_SMTPS : PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = ZOHO_SMTP_PORT;

        // ── Recipients ──
        $mail->setFrom(ZOHO_SMTP_USER, ZOHO_FROM_NAME);
        foreach ((array)$recipients as $to) {
            $mail->addAddress($to);
        }

        if ($replyTo) {
            $mail->addReplyTo($replyTo, $replyToName ?: $replyTo);
        }

        // ── Content ──
        $mail->CharSet  = 'UTF-8';
        $mail->Encoding = 'base64';
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = renderTemplate($templateFile, $placeholders);
        $mail->AltBody = strip_tags($mail->Body);

        $mail->send();
        return ['ok' => true, 'error' => null];
    } catch (Exception $e) {
        return ['ok' => false, 'error' => $mail->ErrorInfo];
    }
}
