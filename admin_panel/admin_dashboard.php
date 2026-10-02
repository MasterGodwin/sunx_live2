<?php
require_once __DIR__ . '/auth.php';
requireRole(['admin']);
require_once __DIR__ . '/messages_api.php';
// ^ populates $leads, $totalLeads, $filteredCount, $isFiltered, $search,
//   $dateFrom, $dateTo, $type, $today, $toast, $toastErr, $loginMap, $pdo.
//   $canRespond will be false here since role is 'admin' — admin only
//   views responses, never submits them.

$adminName = currentUsername($pdo);

$totalJobs = (int) $pdo->query('SELECT COUNT(*) FROM jobs WHERE deleted_at = 0')->fetchColumn();
$totalJobsApplications = (int) $pdo->query('SELECT COUNT(*) FROM job_applications WHERE deleted_at = 0')->fetchColumn();

$activePage = 'dashboard';
$pageTitle = 'Dashboard';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Dashboard – SUN-X Careers</title>
  <link
    href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;800;900&family=Barlow+Condensed:wght@600;700&display=swap"
    rel="stylesheet" />
  <link rel="stylesheet" href="style.css" />
  <link href="../src/assets/images/sun-x(125x55).webp" rel="shortcut icon">
</head>

<body>
  <div class="shell">
    <?php include 'sidebar.php' ?>
    <div class="content">
      <?php include 'navbar.php' ?>
      <main class="main">
        <div class="stats-row"> 
          <div class="stat-card c-red">
            <div class="stat-label">Total Job Applications</div>
            <div class="stat-value red"><?= $totalJobsApplications ?></div>
          </div>
          <div class="stat-card c-yellow">
            <div class="stat-label">Today's Job Applications</div>
            <div class="stat-value yellow">
              <?= $pdo->query("SELECT COUNT(*) FROM job_applications WHERE deleted_at=0 AND DATE(created_at)='$today'")->fetchColumn() ?>
            </div>
          </div>
          <div class="stat-card c-green">
            <div class="stat-label">Today's Messages</div>
            <div class="stat-value green">
              <?= $pdo->query("SELECT COUNT(*) FROM leads WHERE deleted_at=0 AND DATE(created_at)='$today'")->fetchColumn() ?>
            </div>
          </div>
        </div>

        <div class="section-header">
          <h2 class="section-title">Contact Messages</h2>
        </div>

        <!-- Filter bar -->
        <form class="filter-bar" method="GET" action="admin_dashboard.php" id="filterForm">
          <input type="text" name="search" placeholder="Search name, email, phone…"
            value="<?= htmlspecialchars($search) ?>" autocomplete="off"
            onkeydown="if(event.key==='Enter'){event.preventDefault();document.getElementById('filterForm').submit();}" />
          <input type="date" name="date_from" value="<?= htmlspecialchars($dateFrom) ?>" title="From date" />
          <input type="date" name="date_to" value="<?= htmlspecialchars($dateTo) ?>" title="To date" />
          <select name="type" id="typeFilter" title="Filter by type">
            <option value="" <?= $type === '' ? 'selected' : '' ?>>All Types</option>
            <option value="individual" <?= $type === 'individual' ? 'selected' : '' ?>>Individual</option>
            <option value="company" <?= $type === 'company' ? 'selected' : '' ?>>Company</option>
          </select>

          <div class="filter-bar-actions">
            <a href="#" class="filter-reset" id="clearFilters"
              style="<?= $isFiltered ? '' : 'display:none;' ?>">Clear</a>
          </div>

          <span class="filter-count" id="filterCount">
            <?= $isFiltered ? "$filteredCount of $totalLeads shown" : '' ?>
          </span>
        </form>

        <?php include __DIR__ . '/leads_table.php'; ?>
      </main>
    </div>
  </div>

  <!-- Lead Detail Modal -->
  <div class="modal-overlay" id="leadModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:500;align-items:center;justify-content:center;padding:16px;">
    <div class="modal" style="max-width:520px;width:100%;">
      <div class="modal-header">
        <h3 class="modal-title" id="leadModalName">Message Detail</h3>
        <button class="modal-close" onclick="closeLeadModal()">✕</button>
      </div>
      <div class="modal-body" style="padding:1.4rem 1.6rem;">
        <table style="width:100%;border-collapse:collapse;font-size:0.84rem;">
          <tr>
            <td style="padding:7px 0;color:var(--muted);width:100px;font-weight:600;vertical-align:top;">Type</td>
            <td id="lmType" style="padding:7px 0;"></td>
          </tr>
          <tr>
            <td style="padding:7px 0;color:var(--muted);width:100px;font-weight:600;vertical-align:top;">Email</td>
            <td id="lmEmail" style="padding:7px 0;"></td>
          </tr>
          <tr>
            <td style="padding:7px 0;color:var(--muted);font-weight:600;vertical-align:top;">Phone</td>
            <td id="lmPhone" style="padding:7px 0;"></td>
          </tr>
          <tr>
            <td style="padding:7px 0;color:var(--muted);font-weight:600;vertical-align:top;">Services</td>
            <td id="lmServices" style="padding:7px 0;"></td>
          </tr>
          <tr>
            <td style="padding:7px 0;color:var(--muted);font-weight:600;vertical-align:top;">Received</td>
            <td id="lmDate" style="padding:7px 0;color:var(--muted);font-size:0.8rem;"></td>
          </tr>
        </table>
        <div style="margin-top:1rem;padding-top:1rem;border-top:1px solid var(--border);">
          <div style="font-size:0.72rem;font-weight:700;color:var(--muted);letter-spacing:.06em;text-transform:uppercase;margin-bottom:.6rem;">Message</div>
          <div id="lmMessage" style="font-size:0.85rem;line-height:1.75;color:var(--text);white-space:pre-wrap;"></div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="cancel-btn" onclick="closeLeadModal()">Close</button>
        <a id="lmMailto" href="#" class="save-btn" style="text-decoration:none;">Reply by Email →</a>
      </div>
    </div>
  </div>

  <!-- Response view modal (read-only — Admin cannot respond, only view) -->
  <div class="modal-overlay" id="responseModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:600;align-items:center;justify-content:center;padding:16px;">
    <div class="modal" style="max-width:460px;width:100%;">
      <div class="modal-header">
        <h3 class="modal-title" id="respModalTitle">Response</h3>
        <button class="modal-close" onclick="closeResponse()">✕</button>
      </div>
      <div class="modal-body" style="padding:1.4rem 1.6rem;">
        <div style="margin-bottom:10px;font-size:0.84rem;"><strong>Status:</strong> <span id="respStatus"></span></div>
        <div style="margin-bottom:10px;font-size:0.84rem;"><strong>Responded by:</strong> <span id="respBy"></span> <span id="respAt" style="color:var(--muted);"></span></div>
        <div style="font-size:0.72rem;font-weight:700;color:var(--muted);letter-spacing:.06em;text-transform:uppercase;margin:14px 0 6px;">Reason</div>
        <div id="respReasonView" style="font-size:0.85rem;line-height:1.7;color:var(--text);white-space:pre-wrap;"></div>
      </div>
      <div class="modal-footer">
        <button class="cancel-btn" onclick="closeResponse()">Close</button>
      </div>
    </div>
  </div>

  <!-- Delete confirm -->
  <div class="confirm-modal" id="confirmModal">
    <div class="confirm-box">
      <div class="confirm-icon">🗑️</div>
      <div class="confirm-title">Delete This Lead?</div>
      <div class="confirm-text">This will permanently remove the contact Message from your list.</div>
      <form method="POST" action="messages_api.php">
        <input type="hidden" name="action" value="delete" />
        <input type="hidden" name="lead_id" id="delLeadId" value="0" />
        <div class="confirm-actions">
          <button type="button" class="confirm-cancel" onclick="closeConfirm()">Keep It</button>
          <button type="submit" class="confirm-del">Yes, Delete</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Toast -->
  <?php if ($toast): ?>
    <div class="toast" id="toast" style="border-left-color:<?= $toastErr ? 'var(--red)' : 'var(--green)' ?>">
      <?= $toast ?>
    </div>
  <?php else: ?>
    <div class="toast" id="toast"></div>
  <?php endif; ?>

  <script>
    function markRead(table, id) {
      const badge = document.getElementById('lead-badge-' + id);
      if (badge) badge.remove();
      const fd = new FormData();
      fd.append('table', table);
      fd.append('id', id);
      fetch('mark_read.php', { method: 'POST', body: fd }).catch(() => {});
    }

    function viewLead(id, name, email, phone, services, message, date, type) {
      markRead('leads', id);
      document.getElementById('leadModalName').textContent  = name;
      document.getElementById('lmType').textContent         = type === 'company' ? 'Company' : 'Individual';
      document.getElementById('lmEmail').innerHTML          = '<a href="mailto:' + email + '" style="color:var(--red);text-decoration:none;">' + email + '</a>';
      document.getElementById('lmPhone').textContent        = phone;
      document.getElementById('lmServices').textContent     = services;
      document.getElementById('lmDate').textContent         = date;
      document.getElementById('lmMessage').textContent      = message;
      document.getElementById('lmMailto').href              = 'mailto:' + email;
      const modal = document.getElementById('leadModal');
      modal.style.display = 'flex';
    }

    function closeLeadModal() {
      document.getElementById('leadModal').style.display = 'none';
    }

    document.getElementById('leadModal').addEventListener('click', function(e) {
      if (e.target === this) closeLeadModal();
    });

    function viewResponse(name, statusLabel, reason, respondedBy, respondedAt) {
      document.getElementById('respModalTitle').textContent = 'Response — ' + name;
      document.getElementById('respStatus').textContent = statusLabel;
      document.getElementById('respBy').textContent = respondedBy || '—';
      document.getElementById('respAt').textContent = respondedAt ? '(' + respondedAt + ')' : '';
      document.getElementById('respReasonView').textContent = reason || '—';
      document.getElementById('responseModal').style.display = 'flex';
    }
    function closeResponse() {
      document.getElementById('responseModal').style.display = 'none';
    }
    document.getElementById('responseModal').addEventListener('click', function (e) {
      if (e.target === this) closeResponse();
    });

    function openConfirm(id) {
      document.getElementById('delLeadId').value = id;
      document.getElementById('confirmModal').classList.add('open');
    }
    function closeConfirm() {
      document.getElementById('confirmModal').classList.remove('open');
    }

    const toastEl = document.getElementById('toast');
    if (toastEl && toastEl.textContent.trim()) {
      toastEl.classList.add('show');
      setTimeout(() => toastEl.classList.remove('show'), 3500);
    }

    /* ── Auto filter (no query params shown in URL) ── */
    (function () {
      const form = document.getElementById('filterForm');
      const searchInput = form.querySelector('input[name="search"]');
      const dateFrom = form.querySelector('input[name="date_from"]');
      const dateTo = form.querySelector('input[name="date_to"]');
      const typeFilter = document.getElementById('typeFilter');
      const clearBtn = document.getElementById('clearFilters');
      let debounceTimer = null;

      function todayStr() {
        const d = new Date();
        return d.getFullYear() + '-' + String(d.getMonth() + 1).padStart(2, '0') + '-' + String(d.getDate()).padStart(2, '0');
      }

      function runFilter() {
        const params = new URLSearchParams();
        if (searchInput.value.trim()) params.set('search', searchInput.value.trim());
        if (dateFrom.value) params.set('date_from', dateFrom.value);
        if (dateTo.value) params.set('date_to', dateTo.value);
        if (typeFilter.value) params.set('type', typeFilter.value);
        params.set('ajax', '1');

        fetch('messages_api.php?' + params.toString())
          .then(r => r.text())
          .then(html => {
            document.getElementById('ajaxRegion').outerHTML = html;
            const isFiltered = searchInput.value.trim() !== ''
              || dateFrom.value !== todayStr() || dateTo.value !== todayStr()
              || typeFilter.value !== '';
            clearBtn.style.display = isFiltered ? '' : 'none';
          })
          .catch(() => { });

        history.replaceState(null, '', 'admin_dashboard.php');
      }

      function debouncedFilter() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(runFilter, 350);
      }

      searchInput.addEventListener('input', debouncedFilter);
      dateFrom.addEventListener('change', runFilter);
      dateTo.addEventListener('change', runFilter);
      typeFilter.addEventListener('change', runFilter);
      searchInput.addEventListener('keydown', e => { if (e.key === 'Enter') e.preventDefault(); });

      clearBtn.addEventListener('click', function (e) {
        e.preventDefault();
        searchInput.value = '';
        dateFrom.value = todayStr();
        dateTo.value = todayStr();
        typeFilter.value = '';
        runFilter();
      });
    })();
  </script>
</body>

</html>
