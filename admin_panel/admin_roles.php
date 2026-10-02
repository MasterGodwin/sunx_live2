<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/roles_api.php';
// ^ populates $jobs, $totalJobs, $fullTimeJobs, $hiringJobs, $typeMap,
//   $countryMap, $statusMap, $search, $toast, $toastErr, $pdo — and
//   handles the POST (save/delete) case itself (exiting early).

$adminName = currentUsername($pdo);

$activePage = 'roles';
$pageTitle = 'Roles';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Roles – SUN-X Careers</title>
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
                        <div class="stat-label">Total Roles</div>
                        <div class="stat-value red"><?= $totalJobs ?></div>
                    </div>
                    <div class="stat-card c-yellow">
                        <div class="stat-label">Full Time</div>
                        <div class="stat-value yellow"><?= $fullTimeJobs ?></div>
                    </div>
                    <div class="stat-card c-green">
                        <div class="stat-label">Hiring Now</div>
                        <div class="stat-value green"><?= $hiringJobs ?></div>
                    </div>
                </div>

                <div class="section-header">
                    <h2 class="section-title">Job Openings</h2>
                    <button class="add-btn" onclick="openModal()">+ Add Role</button>
                </div>


                <!-- Search bar -->
                <form class="filter-bar" method="GET" action="admin_roles.php" id="rolesSearchForm">
                    <input type="text" name="search" placeholder="Search job title, location, experience…"
                        value="<?= htmlspecialchars($search) ?>" autocomplete="off"
                        onkeydown="if(event.key==='Enter'){event.preventDefault();document.getElementById('rolesSearchForm').submit();}"
                        style="flex:1;min-width:200px;max-width:400px;" />
                    <div class="filter-bar-actions">
                            <?php if ($search !== ''): ?>
                            <a href="admin_roles.php" class="filter-reset">Clear</a>
                            <span class="filter-count"><?= count($jobs) ?> of <?= $totalJobs ?> shown</span>
                            <?php endif; ?>
                        <button type="submit" class="add-btn" style="height:36px;padding:0 1rem;">Search</button>
                    </div>
                </form>
                <div class="table-wrap">
                    <?php if (empty($jobs)): ?>
                        <div class="table-empty">No job openings yet. Click "Add Role" to create the first one.</div>
                    <?php else: ?>
                        <table>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Role Title</th>
                                    <th>Type</th>
                                    <th>Country</th>
                                    <th>Location</th>
                                    <th>Experience</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($jobs as $i => $job): ?>
                                    <?php
                                    $typeName = $typeMap[(int) $job['employment_type']] ?? 'Full Time';
                                    $statusName = $statusMap[(int) $job['status']] ?? 'Hiring Now';
                                    $countryName = $countryMap[(int) $job['country']] ?? 'India';
                                    $typeBadge = (int) $job['employment_type'] === 1 ? 'fulltime' : 'parttime';
                                    $statBadge = (int) $job['status'] === 1 ? 'hiring' : 'muted';
                                    ?>
                                    <tr>
                                        <td style="color:var(--muted);font-size:0.75rem;">
                                            <?= str_pad($i + 1, 2, '0', STR_PAD_LEFT) ?>
                                        </td>
                                        <td class="role-title-cell"><?= htmlspecialchars($job['job_title']) ?></td>
                                        <td><span class="badge <?= $typeBadge ?>"><?= htmlspecialchars($typeName) ?></span></td>
                                        <td><span class="badge country"><?= htmlspecialchars($countryName) ?></span></td>
                                        <td><span class="badge location"><?= htmlspecialchars($job['location'] ?: '—') ?></span>
                                        </td>
                                        <td style="color:var(--muted);font-size:0.8rem;">
                                            <?= htmlspecialchars($job['experience_required'] ?: '—') ?>
                                        </td>
                                        <td><span class="badge <?= $statBadge ?>"><?= htmlspecialchars($statusName) ?></span>
                                        </td>
                                        <td>
                                            <div class="action-btns">
                                                <button class="edit-btn" onclick="openEdit(
                          <?= $job['id'] ?>,
                          <?= htmlspecialchars(json_encode($job['job_title']), ENT_QUOTES) ?>,
                          <?= (int) $job['employment_type'] ?>,
                          <?= (int) $job['country'] ?>,
                          <?= htmlspecialchars(json_encode($job['location']), ENT_QUOTES) ?>,
                          <?= htmlspecialchars(json_encode($job['experience_required']), ENT_QUOTES) ?>,
                          <?= (int) $job['status'] ?>,
                          <?= htmlspecialchars(json_encode($job['job_description']), ENT_QUOTES) ?>
                        )">Edit</button>
                                                <button class="del-btn" onclick="openConfirm(<?= $job['id'] ?>)">Delete</button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>

            </main>
        </div>
    </div>

    <div class="modal-overlay" id="modalOverlay">
        <div class="modal">
            <div class="modal-header">
                <h3 class="modal-title" id="modalTitle">Add New Role</h3>
                <button class="modal-close" onclick="closeModal()">✕</button>
            </div>
            <form method="POST" action="roles_api.php" id="roleForm">
                <input type="hidden" name="action" value="save" />
                <input type="hidden" name="job_id" id="fJobId" value="0" />
                <div class="modal-body">
                    <div class="form-grid">
                        <div class="field">
                            <label for="fTitle">Job Title *</label>
                            <input type="text" id="fTitle" name="fTitle" placeholder="e.g. Logistics Supervisor"
                                required />
                        </div>
                        <div class="field">
                            <label for="fType">Employment Type</label>
                            <select id="fType" name="fType">
                                <option value="1">Full Time</option>
                                <option value="2">Part Time</option>
                                <option value="3">Contract</option>
                                <option value="4">Internship</option>
                            </select>
                        </div> 
                        <div class="field">
                            <label for="fcountry">Country</label>
                            <select id="fcountry" name="fcountry">
                                <option value="1">India</option>
                                <option value="2">Dubai</option> 
                            </select>
                        </div> 
                        <div class="field">
                            <label for="fLocation">Location</label>
                            <input type="text" id="fLocation" name="fLocation" placeholder="e.g. Chennai" />
                        </div>
                        <div class="field">
                            <label for="fExp">Experience Required</label>
                            <input type="text" id="fExp" name="fExp" placeholder="e.g. 1–2 Years" />
                        </div>
                        <div class="field">
                            <label for="fStatus">Status</label>
                            <select id="fStatus" name="fStatus">
                                <option value="1">Hiring Now</option>
                                <option value="2">In Active</option> 
                            </select>
                        </div>
                        <div class="field full">
                            <label for="fDesc">Job Description *</label>
                            <textarea id="fDesc" name="fDesc" placeholder="Describe the role responsibilities…"
                                required></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="cancel-btn" onclick="closeModal()">Cancel</button>
                    <button type="submit" class="save-btn">Save Role</button>
                </div>
            </form>
        </div>
    </div>

    <div class="confirm-modal" id="confirmModal">
        <div class="confirm-box">
            <div class="confirm-icon">🗑️</div>
            <div class="confirm-title">Delete This Role?</div>
            <div class="confirm-text">This will remove the job opening from your careers page.</div>
            <form method="POST" action="roles_api.php">
                <input type="hidden" name="action" value="delete" />
                <input type="hidden" name="job_id" id="delJobId" value="0" />
                <div class="confirm-actions">
                    <button type="button" class="confirm-cancel" onclick="closeConfirm()">Keep It</button>
                    <button type="submit" class="confirm-del">Yes, Delete</button>
                </div>
            </form>
        </div>
    </div>

    <?php if ($toast): ?>
        <div class="toast" id="toast" style="border-left-color: <?= $toastErr ? 'var(--red)' : 'var(--green)' ?>">
            <?= $toast ?>
        </div>
    <?php else: ?>
        <div class="toast" id="toast"></div>
    <?php endif; ?>

    <script>
        function openModal() {
            document.getElementById('modalTitle').textContent = 'Add New Role';
            document.getElementById('fJobId').value = '0';
            document.getElementById('fTitle').value = '';
            document.getElementById('fType').value = '1';
            document.getElementById('fcountry').value = '1';
            document.getElementById('fLocation').value = '';
            document.getElementById('fExp').value = '';
            document.getElementById('fStatus').value = '1';
            document.getElementById('fDesc').value = '';
            document.getElementById('modalOverlay').classList.add('open');
            document.getElementById('fTitle').focus();
        }

        function openEdit(id, title, type, country, location, exp, status, desc) {
            document.getElementById('modalTitle').textContent = 'Edit Role';
            document.getElementById('fJobId').value = id;
            document.getElementById('fTitle').value = title;
            document.getElementById('fType').value = type;
            document.getElementById('fcountry').value = country;
            document.getElementById('fLocation').value = location;
            document.getElementById('fExp').value = exp;
            document.getElementById('fStatus').value = status;
            document.getElementById('fDesc').value = desc;
            document.getElementById('modalOverlay').classList.add('open');
            document.getElementById('fTitle').focus();
        }

        function closeModal() {
            document.getElementById('modalOverlay').classList.remove('open');
        }

        function openConfirm(id) {
            document.getElementById('delJobId').value = id;
            document.getElementById('confirmModal').classList.add('open');
        }

        function closeConfirm() {
            document.getElementById('confirmModal').classList.remove('open');
        }

        document.getElementById('modalOverlay').addEventListener('click', e => {
            if (e.target === e.currentTarget) closeModal();
        });

        const toastEl = document.getElementById('toast');
        if (toastEl && toastEl.textContent.trim() !== '') {
            toastEl.classList.add('show');
            setTimeout(() => toastEl.classList.remove('show'), 3500);
        }
    </script>
</body>

</html>
