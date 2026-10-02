<?php
require_once __DIR__ . '/auth.php';

if (!empty($_SESSION['sunx_admin_auth'])) {
  header('Location: ' . roleHome(currentRole()));
  exit;
}

// Which login tab is active: 'admin' or 'user' (hr/sales)
$loginTab = ($_GET['tab'] ?? 'admin') === 'user' ? 'user' : 'admin';

$error = '';
if (!empty($_GET['error'])) {
  $error = $_GET['error'];
} elseif (!empty($_GET['timeout'])) {
  $error = 'Your session expired after an hour of inactivity. Please sign in again.';
}
$prefillUser = $_GET['u'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Login – SUN-X Concrete</title>
  <link
    href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;800;900&family=Barlow+Condensed:wght@600;700&display=swap"
    rel="stylesheet" />
  <link rel="stylesheet" href="style.css" />
  <link href="../src/assets/images/sun-x(125x55).webp" rel="shortcut icon">
</head>

<body class="login-body">

  <div class="login-card">
    <div class="brand-logo">
      <span class="brand-badge">Admin</span>
      <span class="brand-name" style="color: #fec403;">SUN-X CONCRETE</span>
    </div>

    <h1 class="login-title" style="color: #700707">CAREERS<span style="color: #fec403"> PANEL</span></h1>
    <p class="login-sub">Sign in to manage job openings</p>

    <!-- Admin / User login tabs -->
    <div class="login-tabs" style="display:flex;gap:8px;margin:14px 0 18px;border:1px solid var(--border,#e5e5e5);border-radius:10px;padding:4px;">
      <button type="button" class="login-tab-btn <?= $loginTab === 'admin' ? 'active' : '' ?>" data-tab="admin"
        style="flex:1;padding:9px 0;border:none;border-radius:7px;cursor:pointer;font-weight:700;font-size:0.82rem;letter-spacing:.03em;
               background:<?= $loginTab === 'admin' ? 'var(--red,#700707)' : 'transparent' ?>;
               color:<?= $loginTab === 'admin' ? '#fff' : 'var(--text,#1a1a1a)' ?>;">Admin Login</button>
      <button type="button" class="login-tab-btn <?= $loginTab === 'user' ? 'active' : '' ?>" data-tab="user"
        style="flex:1;padding:9px 0;border:none;border-radius:7px;cursor:pointer;font-weight:700;font-size:0.82rem;letter-spacing:.03em;
               background:<?= $loginTab === 'user' ? 'var(--red,#700707)' : 'transparent' ?>;
               color:<?= $loginTab === 'user' ? '#fff' : 'var(--text,#1a1a1a)' ?>;">User Login</button>
    </div>
    <p class="login-sub" id="tabHint" style="margin-top:-10px;font-size:0.78rem;">
      <?= $loginTab === 'user' ? 'For HR &amp; Sales team members' : 'For the site administrator' ?>
    </p>

    <form method="POST" action="login_api.php">
      <input type="hidden" name="login_tab" id="login_tab" value="<?= htmlspecialchars($loginTab) ?>" />

      <div class="field">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" placeholder="admin" autocomplete="username"
          value="<?= htmlspecialchars($prefillUser) ?>" />
      </div>

      <div class="field">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="••••••••" autocomplete="current-password" />
      </div>

      <button class="login-btn" type="submit">Sign In →</button>

      <?php if ($error): ?>
        <div class="error-msg"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>
    </form>

    <script>
      (function () {
        var hidden = document.getElementById('login_tab');
        document.querySelectorAll('.login-tab-btn').forEach(function (btn) {
          btn.addEventListener('click', function () {
            hidden.value = this.dataset.tab;
            document.querySelectorAll('.login-tab-btn').forEach(function (b) {
              b.classList.remove('active');
              b.style.background = 'transparent';
              b.style.color = 'var(--text,#1a1a1a)';
            });
            this.classList.add('active');
            this.style.background = 'var(--red,#700707)';
            this.style.color = '#fff';
            document.getElementById('tabHint').textContent =
              this.dataset.tab === 'user' ? 'For HR & Sales team members' : 'For the site administrator';
          });
        });
      })();
    </script>

    <a href="../careers.php" class="back-link">← Back to Careers Page</a>

    <div class="footer-note">SUN-X Concrete Pvt Ltd · Internal Admin</div>
  </div>

</body>

</html>
