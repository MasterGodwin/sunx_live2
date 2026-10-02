<?php
// ── mail_config.php ──────────────────────────────────────────
// Zoho SMTP credentials used by mailer.php to send notification
// emails for the Careers and Contact forms.
//
// ZOHO_SMTP_HOST/PORT/SECURE -> SMTP connection settings
// ZOHO_SMTP_USER/PASS        -> the Zoho mailbox + Application Password
//                                used to LOG IN and SEND (the "From" address)
// CAREERS_NOTIFY_EMAILS      -> who receives Careers form notifications
// CONTACT_NOTIFY_EMAILS      -> who receives Contact form notifications
//
// Keep this file OUTSIDE any publicly browsable /uploads style folder,
// and ideally outside webroot if your hosting allows it.

define('ZOHO_SMTP_HOST', 'smtp.zoho.in');        // India DC (matches zohomail.in) — use smtp.zoho.com if that fails
define('ZOHO_SMTP_PORT', 587);                   // 587 = STARTTLS, 465 = SSL
define('ZOHO_SMTP_SECURE', 'tls');               // 'tls' for 587, 'ssl' for 465

define('ZOHO_SMTP_USER', 'nesarajgodwin@zohomail.in');   // login mailbox (also the "From" address)
define('ZOHO_SMTP_PASS', 'TUjL1SZTNvF9');                  // your Zoho Application Password

define('ZOHO_FROM_NAME', 'SUN-X Concrete Website');

// ── Recipients (who receives the notification email) ──
// Careers form submissions go to:
define('CAREERS_NOTIFY_EMAILS', [
    'nesarajgodwin@zohomail.in',
    'nesarajgodwin80@gmail.com',
]);

// Contact form submissions go to:
define('CONTACT_NOTIFY_EMAILS', [
    'nesarajgodwin@zohomail.in',
    'nesarajgodwin78@gmail.com',
]);
