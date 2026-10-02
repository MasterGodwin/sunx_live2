<?php
$pageTitle  = $pageTitle  ?? 'Dashboard';
$activePage = $activePage ?? '';
$adminName  = $adminName  ?? 'Admin';
$adminInitial = strtoupper(substr($adminName, 0, 1));
$navRole = $_SESSION['sunx_admin_role'] ?? 'admin';
?>
<header class="navbar">
  <div class="navbar-left"> 
    <button class="menu-toggle" id="menuToggle" aria-label="Menu">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <line x1="3" y1="8"  x2="21" y2="8"/>
        <line x1="3" y1="16" x2="21" y2="16"/>
      </svg>
    </button>

    <a href="admin_dashboard.php" class="navbar-brand">
      <img src="../src/assets/images/sun-x.png"
           alt="SUN-X" class="navbar-logo" /> 
    </a>

    <nav class="navbar-nav">
      <?php if ($navRole === 'admin'): ?>
      <a href="admin_dashboard.php"
         class="nav-link <?= $activePage === 'dashboard'    ? 'active' : '' ?>">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <rect x="3" y="3" width="7" height="9" rx="1"/>
          <rect x="14" y="3" width="7" height="5" rx="1"/>
          <rect x="14" y="12" width="7" height="9" rx="1"/>
          <rect x="3" y="16" width="7" height="5" rx="1"/>
        </svg>
        Dashboard
      </a>
      <?php endif; ?>

      <?php if ($navRole === 'admin' || $navRole === 'hr'): ?>
      <a href="admin_roles.php"
         class="nav-link <?= $activePage === 'roles'        ? 'active' : '' ?>">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <rect x="2" y="7" width="20" height="14" rx="2"/>
          <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
        </svg>
        Roles
      </a>
      <a href="admin_applications.php"
         class="nav-link <?= $activePage === 'applications' ? 'active' : '' ?>">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
          <polyline points="14 2 14 8 20 8"/>
          <line x1="16" y1="13" x2="8" y2="13"/>
          <line x1="16" y1="17" x2="8" y2="17"/>
        </svg>
        Applications
      </a>
      <?php endif; ?>

      <?php if ($navRole === 'sales'): ?>
      <a href="sales_messages.php"
         class="nav-link <?= $activePage === 'messages' ? 'active' : '' ?>">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
        </svg>
        Contact Messages
      </a>
      <?php endif; ?>
    </nav>
  </div>

  <!-- RIGHT: view site + profile dropdown -->
  <div class="navbar-right">
    <a href="../careers.php" class="navbar-link" target="_blank">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/>
        <polyline points="15 3 21 3 21 9"/>
        <line x1="10" y1="14" x2="21" y2="3"/>
      </svg>
      <span class="navbar-link-label">View Site</span>
    </a>

    <!-- Profile dropdown -->
    <div class="profile-wrap" id="profileWrap">
      <button class="profile-btn" id="profileBtn" aria-haspopup="true" aria-expanded="false">
        <div class="profile-avatar"><?= htmlspecialchars($adminInitial) ?></div>
        <span class="profile-name"><?= htmlspecialchars($adminName) ?></span>
        <svg class="profile-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <polyline points="6 9 12 15 18 9"/>
        </svg>
      </button>
      <div class="profile-dropdown" id="profileDropdown">
        <div class="profile-dropdown-info">
          <div class="profile-avatar lg"><?= htmlspecialchars($adminInitial) ?></div>
          <div>
            <div class="profile-dropdown-name"><?= htmlspecialchars($adminName) ?></div>
            <div class="profile-dropdown-role">Administrator</div>
          </div>
        </div>
        <div class="profile-dropdown-divider"></div>
        <a href="login_api.php?action=logout" class="profile-dropdown-item logout">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
            <polyline points="16 17 21 12 16 7"/>
            <line x1="21" y1="12" x2="9" y2="12"/>
          </svg>
          Sign Out
        </a>
      </div>
    </div>

  </div>
</header>

<!-- Mobile nav drawer -->
<div class="mobile-nav-backdrop" id="mobileNavBackdrop"></div>
<nav class="mobile-nav" id="mobileNav">
  <?php if ($navRole === 'admin'): ?>
    <a href="admin_dashboard.php"    class="nav-link <?= $activePage === 'dashboard'    ? 'active' : '' ?>">Dashboard</a>
  <?php endif; ?>
  <?php if ($navRole === 'admin' || $navRole === 'hr'): ?>
    <a href="admin_roles.php"        class="nav-link <?= $activePage === 'roles'        ? 'active' : '' ?>">Roles</a>
    <a href="admin_applications.php" class="nav-link <?= $activePage === 'applications' ? 'active' : '' ?>">Applications</a>
  <?php endif; ?>
  <?php if ($navRole === 'sales'): ?>
    <a href="sales_messages.php" class="nav-link <?= $activePage === 'messages' ? 'active' : '' ?>">Contact Messages</a>
  <?php endif; ?>
  <div class="mobile-nav-divider"></div>
  <a href="login_api.php?action=logout" class="nav-link logout">Sign Out</a>
</nav>

<script>
document.addEventListener('DOMContentLoaded', () => {
  // ── Back-button guard: if user navigates back after logout, redirect to login ──
  // pageshow fires on back/forward navigation (even from cache)
  window.addEventListener('pageshow', function(e) {
    if (e.persisted) {
      // Page was restored from bfcache — check if still logged in
      fetch('auth.php?action=check', { method: 'GET', credentials: 'same-origin' })
        .then(r => r.json())
        .then(d => { if (!d.ok) window.location.replace('index.php'); })
        .catch(() => { window.location.replace('index.php'); });
    }
  });

  // Profile dropdown
  const profileBtn      = document.getElementById('profileBtn');
  const profileDropdown = document.getElementById('profileDropdown');
  if (profileBtn && profileDropdown) {
    profileBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      const open = profileDropdown.classList.toggle('open');
      profileBtn.setAttribute('aria-expanded', open);
    });
    document.addEventListener('click', () => {
      profileDropdown.classList.remove('open');
      profileBtn.setAttribute('aria-expanded', 'false');
    });
  }

  // Mobile nav
  const menuToggle = document.getElementById('menuToggle');
  const mobileNav  = document.getElementById('mobileNav');
  const backdrop   = document.getElementById('mobileNavBackdrop');
  if (menuToggle && mobileNav) {
    menuToggle.addEventListener('click', () => {
      mobileNav.classList.toggle('open');
      backdrop.classList.toggle('open');
    });
    backdrop.addEventListener('click', () => {
      mobileNav.classList.remove('open');
      backdrop.classList.remove('open');
    });
  }
});
</script>