<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/applications_api.php';
// ^ populates $applications, $totalApps, $filteredCount, $isFiltered,
//   $positions, $search, $dateFrom, $dateTo, $position, $today, $toast,
//   $toastErr, $canRespond, $role, $loginMap, $pdo — and handles the
//   POST (delete/respond) and GET ajax=1 cases itself (exiting early).

$adminName = currentUsername($pdo);

$activePage = 'applications';
$pageTitle = 'Applications';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Applications – SUN-X Careers</title>
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
            <div class="stat-label">Total Applications</div>
            <div class="stat-value red">
              <?= $totalApps ?>
            </div>
          </div>

          <div class="stat-card c-yellow">
            <div class="stat-label">Today's Applications</div>
            <div class="stat-value yellow">
             <?= $pdo->query("SELECT COUNT(*) FROM job_applications WHERE deleted_at=0 AND DATE(created_at)='$today'")->fetchColumn() ?>
            </div>
          </div>
        </div>

        <!-- Section header -->
        <div class="section-header">
          <h2 class="section-title">Job Applications</h2>
        </div>

        <!-- ── Filter Bar ── -->
        <form class="filter-bar" method="GET" action="admin_applications.php" id="filterForm">
          <input type="text" name="search" placeholder="Search name, email, phone…"
            value="<?= htmlspecialchars($search) ?>" autocomplete="off"
            onkeydown="if(event.key==='Enter'){event.preventDefault();document.getElementById('filterForm').submit();}" />

          <select name="position">
            <option value="">All Positions</option>
            <?php foreach ($positions as $pos): ?>
              <option value="<?= htmlspecialchars($pos) ?>" <?= $position === $pos ? 'selected' : '' ?>>
                <?= htmlspecialchars($pos) ?>
              </option>
            <?php endforeach; ?>
          </select>

          <input type="date" name="date_from" value="<?= htmlspecialchars($dateFrom) ?>" title="From date" />
          <input type="date" name="date_to" value="<?= htmlspecialchars($dateTo) ?>" title="To date" />

          <div class="filter-bar-actions">
            <a href="#" class="filter-reset" id="clearFilters"
              style="<?= $isFiltered ? '' : 'display:none;' ?>">Clear</a>
          </div>

          <span class="filter-count"
            id="filterCount"><?= $isFiltered ? "$filteredCount of $totalApps shown" : '' ?></span>
        </form>

        <?php include __DIR__ . '/applications_table.php'; ?>

      </main>
    </div>
  </div>

  <!-- Delete confirm -->
  <div class="confirm-modal" id="confirmModal">
    <div class="confirm-box">
      <div class="confirm-icon">🗑️</div>
      <div class="confirm-title">Delete This Application?</div>
      <div class="confirm-text">This will remove the application from your list.</div>
      <form method="POST" action="applications_api.php">
        <input type="hidden" name="action" value="delete" />
        <input type="hidden" name="app_id" id="delAppId" value="0" />
        <div class="confirm-actions">
          <button type="button" class="confirm-cancel" onclick="closeConfirm()">Keep It</button>
          <button type="submit" class="confirm-del">Yes, Delete</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Toast -->
  <?php if ($toast): ?>
    <div class="toast" id="toast" style="border-left-color:<?= $toastErr ? 'var(--red)' : 'var(--green)' ?>"><?= $toast ?>
    </div>
  <?php else: ?>
    <div class="toast" id="toast"></div>
  <?php endif; ?>

  <?php if ($canRespond): ?>
  <!-- Response modal (HR fills this in) -->
  <div class="modal-overlay" id="responseModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:600;align-items:center;justify-content:center;padding:16px;">
    <div class="modal" style="max-width:480px;width:100%;">
      <div class="modal-header">
        <h3 class="modal-title" id="respModalTitle">Respond</h3>
        <button class="modal-close" onclick="closeResponse()">✕</button>
      </div>
      <form method="POST" action="applications_api.php" id="responseForm">
        <input type="hidden" name="action" value="respond" />
        <input type="hidden" name="app_id" id="respAppId" value="0" />
        <div class="modal-body" style="padding:1.4rem 1.6rem;">
          <div class="field full" style="margin-bottom:1rem;">
            <label for="respReason">Reason</label>
            <textarea id="respReason" name="reason" rows="4" placeholder="Write your response / reason…"></textarea>
          </div>
          <div class="field full">
            <label>Status</label>
            <div style="display:flex;gap:16px;flex-wrap:wrap;margin-top:6px;">
              <label style="display:flex;align-items:center;gap:6px;font-weight:500;font-size:0.85rem;cursor:pointer;text-transform:none;letter-spacing:normal;flex-shrink:0;white-space:nowrap;">
                <input type="radio" name="status" value="approved" required /> <span style="text-transform:none;">Approved</span>
              </label>
              <label style="display:flex;align-items:center;gap:6px;font-weight:500;font-size:0.85rem;cursor:pointer;text-transform:none;letter-spacing:normal;flex-shrink:0;white-space:nowrap;">
                <input type="radio" name="status" value="inprogress" /> <span style="text-transform:none;">In Progress</span>
              </label>
              <label style="display:flex;align-items:center;gap:6px;font-weight:500;font-size:0.85rem;cursor:pointer;text-transform:none;letter-spacing:normal;flex-shrink:0;white-space:nowrap;">
                <input type="radio" name="status" value="rejected" /> <span style="text-transform:none;">Rejected</span>
              </label>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="cancel-btn" onclick="closeResponse()">Cancel</button>
          <button type="submit" class="save-btn">Save Response</button>
        </div>
      </form>
    </div>
  </div>
  <?php else: ?>
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
  <?php endif; ?>

  <!-- CV Viewer Modal -->
  <div class="cv-modal-overlay" id="cvModal">
    <div class="cv-modal-box">
      <div class="cv-modal-header">
        <div class="cv-modal-title" id="cvModalTitle">CV Preview</div>
        <div style="display:flex;gap:8px;align-items:center;">
          <a class="edit-btn" id="cvModalDownload" download>Download</a>
          <button class="modal-close" onclick="closeCV()">&#x2715;</button>
        </div>
      </div>
      <div class="cv-modal-body" id="cvModalBody"></div>
    </div>
  </div>

  <style>
    .cv-modal-overlay {
      display: none;
      position: fixed;
      inset: 0;
      background: rgba(0, 0, 0, .55);
      z-index: 1000;
      align-items: center;
      justify-content: center;
      padding: 16px;
    }

    .cv-modal-overlay.open {
      display: flex;
    }

    .cv-modal-box {
      background: var(--surface, #fff);
      border-radius: 12px;
      width: 100%;
      max-width: 860px;
      height: 90vh;
      display: flex;
      flex-direction: column;
      overflow: hidden;
      box-shadow: 0 20px 60px rgba(0, 0, 0, .3);
    }

    .cv-modal-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 14px 18px;
      border-bottom: 1px solid var(--border, #e5e5e5);
      flex-shrink: 0;
    }

    .cv-modal-title {
      font-size: .85rem;
      font-weight: 600;
      color: var(--text, #1a1a1a);
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
      max-width: 60%;
    }

    .cv-modal-body {
      flex: 1;
      overflow: hidden;
      background: #f4f4f4;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .cv-modal-body iframe {
      width: 100%;
      height: 100%;
      border: none;
    }

    .cv-no-preview {
      text-align: center;
      padding: 40px 24px;
      color: var(--muted, #888);
    }

    .cv-no-preview svg {
      width: 48px;
      height: 48px;
      opacity: .4;
      display: block;
      margin: 0 auto 12px;
    }

    .cv-no-preview p {
      font-size: .9rem;
      margin: 0 0 16px;
    }

    @media(max-width:640px) {
      .cv-modal-box {
        height: 95vh;
        border-radius: 8px;
      }
    }
  </style>

  <script>
    function markRead(table, id) {
      const badge = document.getElementById((table === 'job_applications' ? 'app' : 'lead') + '-badge-' + id);
      if (badge) badge.remove();
      const fd = new FormData();
      fd.append('table', table);
      fd.append('id', id);
      fetch('mark_read.php', { method: 'POST', body: fd }).catch(() => {});
    }

    function viewApp(id, url, name, ext) {
      markRead('job_applications', id);
      openCV(url, name, ext);
    }

    function openConfirm(id) {
      document.getElementById('delAppId').value = id;
      document.getElementById('confirmModal').classList.add('open');
    }
    function closeConfirm() {
      document.getElementById('confirmModal').classList.remove('open');
    }

    <?php if ($canRespond): ?>
    function openResponse(id, name, currentStatus, currentReason) {
      document.getElementById('respModalTitle').textContent = 'Respond — ' + name;
      document.getElementById('respAppId').value = id;
      document.getElementById('respReason').value = currentReason || '';
      document.querySelectorAll('#responseForm input[name="status"]').forEach(function (r) {
        r.checked = (r.value === currentStatus);
      });
      document.getElementById('responseModal').style.display = 'flex';
    }
    <?php else: ?>
    function viewResponse(name, statusLabel, reason, respondedBy, respondedAt) {
      document.getElementById('respModalTitle').textContent = 'Response — ' + name;
      document.getElementById('respStatus').textContent = statusLabel;
      document.getElementById('respBy').textContent = respondedBy || '—';
      document.getElementById('respAt').textContent = respondedAt ? '(' + respondedAt + ')' : '';
      document.getElementById('respReasonView').textContent = reason || '—';
      document.getElementById('responseModal').style.display = 'flex';
    }
    <?php endif; ?>
    function closeResponse() {
      document.getElementById('responseModal').style.display = 'none';
    }
    document.getElementById('responseModal').addEventListener('click', function (e) {
      if (e.target === this) closeResponse();
    });

    function openCV(url, name, ext) {
      document.getElementById('cvModalTitle').textContent = name;
      var dl = document.getElementById('cvModalDownload');
      dl.href = url; dl.download = name;
      var body = document.getElementById('cvModalBody');
      if (ext === 'pdf') {
        body.innerHTML = '<iframe src="' + encodeURI(url) + '" title="' + name + '"></iframe>';
      } else if (ext === 'doc' || ext === 'docx') {
        var absUrl = new URL(url, window.location.href).href;
        body.innerHTML = '<iframe src="https://docs.google.com/gview?url=' + encodeURIComponent(absUrl) + '&embedded=true" title="' + name + '"></iframe>';
      } else {
        body.innerHTML = '<div class="cv-no-preview"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg><p>Preview not available.</p><a class="edit-btn" href="' + url + '" download="' + name + '">Download to view</a></div>';
      }
      document.getElementById('cvModal').classList.add('open');
      document.body.style.overflow = 'hidden';
    }
    function closeCV() {
      document.getElementById('cvModal').classList.remove('open');
      document.getElementById('cvModalBody').innerHTML = '';
      document.body.style.overflow = '';
    }
    document.getElementById('cvModal').addEventListener('click', function (e) { if (e.target === this) closeCV(); });
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape') closeCV(); });

    const toastEl = document.getElementById('toast');
    if (toastEl && toastEl.textContent.trim()) {
      toastEl.classList.add('show');
      setTimeout(() => toastEl.classList.remove('show'), 3500);
    }

    /* ── Auto filter (no query params shown in URL) ── */
    (function () {
      const form = document.getElementById('filterForm');
      const searchInput = form.querySelector('input[name="search"]');
      const posSelect = form.querySelector('select[name="position"]');
      const dateFrom = form.querySelector('input[name="date_from"]');
      const dateTo = form.querySelector('input[name="date_to"]');
      const clearBtn = document.getElementById('clearFilters');
      const filterCount = document.getElementById('filterCount');
      let debounceTimer = null;

      function runFilter() {
        const params = new URLSearchParams();
        if (searchInput.value.trim()) params.set('search', searchInput.value.trim());
        if (posSelect.value) params.set('position', posSelect.value);
        if (dateFrom.value) params.set('date_from', dateFrom.value);
        if (dateTo.value) params.set('date_to', dateTo.value);
        params.set('ajax', '1');

        fetch('applications_api.php?' + params.toString())
          .then(r => r.text())
          .then(html => {
            document.getElementById('ajaxRegion').outerHTML = html;

            const isFiltered = searchInput.value.trim() !== '' || posSelect.value !== ''
              || dateFrom.value !== todayStr() || dateTo.value !== todayStr();
            clearBtn.style.display = isFiltered ? '' : 'none';
          })
          .catch(() => { });

        // Keep URL clean — just the filename, no query string
        history.replaceState(null, '', 'admin_applications.php');
      }

      function todayStr() {
        const d = new Date();
        return d.getFullYear() + '-' + String(d.getMonth() + 1).padStart(2, '0') + '-' + String(d.getDate()).padStart(2, '0');
      }

      function debouncedFilter() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(runFilter, 350);
      }

      searchInput.addEventListener('input', debouncedFilter);
      posSelect.addEventListener('change', runFilter);
      dateFrom.addEventListener('change', runFilter);
      dateTo.addEventListener('change', runFilter);
      searchInput.addEventListener('keydown', e => { if (e.key === 'Enter') e.preventDefault(); });

      clearBtn.addEventListener('click', function (e) {
        e.preventDefault();
        searchInput.value = '';
        posSelect.value = '';
        dateFrom.value = todayStr();
        dateTo.value = todayStr();
        runFilter();
      });
    })();
  </script>
</body>

</html>
