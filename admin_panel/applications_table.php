<!-- Partial: expects $applications, $totalApps, $filteredCount, $isFiltered -->
<div id="ajaxRegion">

  <div class="table-wrap">
    <?php if (empty($applications)): ?>
      <div class="table-empty">
        <?= $isFiltered ? 'No applications match your filters.' : 'No applications yet.' ?>
      </div>
    <?php else: ?>
      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>Name</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Position</th>
            <th>Applied On</th>
            <th>Status</th>
            <th>Response</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $statusLabels = ['pending' => 'Pending', 'approved' => 'Approved', 'inprogress' => 'In Progress', 'rejected' => 'Rejected'];
            $statusClasses = ['pending' => 'muted', 'approved' => 'approved', 'inprogress' => 'inprogress', 'rejected' => 'rejected'];
            $role = $role ?? currentRole();
          ?>
          <?php foreach ($applications as $i => $app): ?>
            <?php
              $ext = strtolower(pathinfo($app['cv_original_name'] ?? '', PATHINFO_EXTENSION));
              $aStatus = $app['status'] ?? 'pending';
              $aReason = $app['response_reason'] ?? '';
              $aResponder = !empty($app['responded_by']) ? ($loginMap[(int) $app['responded_by']] ?? '') : '';
            ?>
            <tr id="app-row-<?= (int) $app['id'] ?>">
              <td style="color:var(--muted);font-size:0.75rem;"><?= str_pad($i + 1, 2, '0', STR_PAD_LEFT) ?></td>

              <td class="role-title-cell">
                <span class="name-with-cv">
                  <?= htmlspecialchars($app['first_name']) ?> <?= htmlspecialchars($app['second_name']) ?>
                  <?php if ($app['cv_path']): ?>
                    <button type="button" class="cv-download-icon" title="View CV"
                      onclick="viewApp(
                        <?= (int) $app['id'] ?>,
                        <?= htmlspecialchars(json_encode('../' . $app['cv_path']), ENT_QUOTES) ?>,
                        <?= htmlspecialchars(json_encode($app['cv_original_name']), ENT_QUOTES) ?>,
                        <?= htmlspecialchars(json_encode($ext), ENT_QUOTES) ?>
                      )">
                      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" width="15" height="15">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8Z" />
                        <circle cx="12" cy="12" r="3" />
                      </svg>
                    </button>
                    
                  <?php endif; ?>
                </span>
                <?php if ((int) ($app['new'] ?? 0) === 0): ?>
                  <span class="new-badge" id="app-badge-<?= (int) $app['id'] ?>">NEW</span>
                <?php endif; ?>
              </td>
              <td style="color:var(--muted);font-size:0.8rem;"><?= htmlspecialchars($app['phone'] ?: '—') ?></td>
              <td><a href="mailto:<?= htmlspecialchars($app['email']) ?>"><?= htmlspecialchars($app['email']) ?></a></td>

              <td><span class="badge location"><?= htmlspecialchars($app['position']) ?></span></td>

              <td style="color:var(--muted);font-size:0.78rem;">
                <?= htmlspecialchars(date('d M Y, h:i A', strtotime($app['created_at']))) ?>
              </td>

              <td>
                <span class="badge <?= $statusClasses[$aStatus] ?>"><?= $statusLabels[$aStatus] ?></span>
              </td>

              <td style="max-width:240px;">
                <?php if ($aStatus !== 'pending' && $aReason): ?>
                  <div class="resp-note">
                    <div class="resp-note-meta">
                      <span><?= htmlspecialchars($aResponder ?: '—') ?></span>
                      <?php if (!empty($app['responded_at'])): ?>
                        <span>· <?= htmlspecialchars(date('d M Y, h:i A', strtotime($app['responded_at']))) ?></span>
                      <?php endif; ?>
                    </div>
                    <p class="resp-note-text"><?= htmlspecialchars($aReason) ?></p>
                  </div>
                <?php else: ?>
                  <span style="color:var(--muted);font-size:0.8rem;">—</span>
                <?php endif; ?>
              </td>

              <td>
                <div class="action-btns">
                  <?php if (!empty($canRespond)): ?>
                    <button class="edit-btn" onclick="openResponse(
                      <?= (int) $app['id'] ?>,
                      <?= htmlspecialchars(json_encode($app['first_name']), ENT_QUOTES) ?>,
                      <?= htmlspecialchars(json_encode($aStatus), ENT_QUOTES) ?>,
                      <?= htmlspecialchars(json_encode($aReason), ENT_QUOTES) ?>
                    )">Response</button>
                  <?php endif; ?>

                  <?php if ($role === 'admin'): ?>
                    <button class="del-btn" onclick="openConfirm(<?= (int) $app['id'] ?>)">Delete</button>
                  <?php endif; ?>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </div>

</div>