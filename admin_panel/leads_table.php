<div id="ajaxRegion">
  <div class="table-wrap">
    <?php if (empty($leads)): ?>
      <div class="table-empty">
        <?= $isFiltered ? 'No leads match your filters.' : 'No leads yet for the selected date range.' ?>
      </div>
    <?php else: ?>
      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>Name</th>
            <th>Type</th>
            <th>Phone</th>
            <th>Email</th>
            <!-- <th>Services</th>
            <th>Message</th> -->
            <th>Received On</th>
            <th>Status</th>
            <th>Response</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $statusLabels = ['pending' => 'Pending', 'approved' => 'Approved', 'inprogress' => 'In Progress', 'rejected' => 'Rejected'];
            $statusClasses = ['pending' => 'muted', 'approved' => 'approved', 'inprogress' => 'inprogress', 'rejected' => 'rejected'];
          ?>
          <?php foreach ($leads as $i => $lead): ?>
            <?php
              $lStatus = $lead['status'] ?? 'pending';
              $lReason = $lead['response_reason'] ?? '';
              $lResponder = !empty($lead['responded_by']) ? ($loginMap[(int) $lead['responded_by']] ?? '') : '';
            ?>
            <tr>
              <td style="color:var(--muted);font-size:0.75rem;"><?= str_pad($i + 1, 2, '0', STR_PAD_LEFT) ?></td>
              <?php
                $leadType = ($lead['type'] ?? 'individual') === 'company' ? 'company' : 'individual';
                $displayName = $leadType === 'company'
                  ? ($lead['company_name'] ?: $lead['first_name'])
                  : trim($lead['first_name'] . ' ' . $lead['second_name']);
              ?>
              <td class="role-title-cell">
                <?= htmlspecialchars($displayName) ?>
                <?php if ((int) ($lead['new'] ?? 0) === 0): ?>
                  <span class="new-badge" id="lead-badge-<?= (int) $lead['id'] ?>">NEW</span>
                <?php endif; ?>
              </td>
              <td>
                <span class="badge location" style="font-size:0.72rem;">
                  <?= $leadType === 'company' ? 'Company' : 'Individual' ?>
                </span>
              </td>
              <td style="color:var(--muted);font-size:0.8rem;"><?= htmlspecialchars($lead['phone_number'] ?: '—') ?></td>
              <td>
                <a href="mailto:<?= htmlspecialchars($lead['email']) ?>" style="color:var(--red);text-decoration:none;">
                  <?= htmlspecialchars($lead['email']) ?>
                </a>
              </td>
              <!-- <td>
                <?php if ($lead['services'] && $lead['services'] !== 'None selected'): ?>
                  <span class="badge location" style="white-space:normal;line-height:1.4;">
                    <?= htmlspecialchars($lead['services']) ?>
                  </span>
                <?php else: ?>
                  <span style="color:var(--muted);font-size:0.8rem;">—</span>
                <?php endif; ?>
              </td>
              <td style="max-width:220px;">
                <div style="font-size:0.8rem;color:var(--text);line-height:1.4;
                            overflow:hidden;display:-webkit-box;
                            -webkit-line-clamp:2;-webkit-box-orient:vertical;">
                  <?= htmlspecialchars($lead['message']) ?>
                </div>
              </td> -->
              <td style="color:var(--muted);font-size:0.78rem;white-space:nowrap;">
                <?= htmlspecialchars(date('d M Y, h:i A', strtotime($lead['created_at']))) ?>
              </td>
              <td>
                <span class="badge <?= $statusClasses[$lStatus] ?>"><?= $statusLabels[$lStatus] ?></span>
              </td>

              <td style="max-width:240px;">
                <?php if ($lStatus !== 'pending' && $lReason): ?>
                  <div class="resp-note">
                    <div class="resp-note-meta">
                      <span><?= htmlspecialchars($lResponder ?: '—') ?></span>
                      <?php if (!empty($lead['responded_at'])): ?>
                        <span>· <?= htmlspecialchars(date('d M Y, h:i A', strtotime($lead['responded_at']))) ?></span>
                      <?php endif; ?>
                    </div>
                    <p class="resp-note-text"><?= htmlspecialchars($lReason) ?></p>
                  </div>
                <?php else: ?>
                  <span style="color:var(--muted);font-size:0.8rem;">—</span>
                <?php endif; ?>
              </td>

              <td>
                <div class="action-btns">
                  <button class="edit-btn" onclick="viewLead(
                    <?= (int) $lead['id'] ?>,
                    <?= htmlspecialchars(json_encode($displayName), ENT_QUOTES) ?>,
                    <?= htmlspecialchars(json_encode($lead['email']), ENT_QUOTES) ?>,
                    <?= htmlspecialchars(json_encode($lead['phone_number'] ?: '—'), ENT_QUOTES) ?>,
                    <?= htmlspecialchars(json_encode($lead['services'] ?: '—'), ENT_QUOTES) ?>,
                    <?= htmlspecialchars(json_encode($lead['message']), ENT_QUOTES) ?>,
                    <?= htmlspecialchars(json_encode(date('d M Y, h:i A', strtotime($lead['created_at']))), ENT_QUOTES) ?>,
                    <?= htmlspecialchars(json_encode($leadType), ENT_QUOTES) ?>
                  )">View</button>

                  <?php if (!empty($canRespond)): ?>
                    <button class="edit-btn" onclick="openResponse(
                      <?= (int) $lead['id'] ?>,
                      <?= htmlspecialchars(json_encode($displayName), ENT_QUOTES) ?>,
                      <?= htmlspecialchars(json_encode($lStatus), ENT_QUOTES) ?>,
                      <?= htmlspecialchars(json_encode($lReason), ENT_QUOTES) ?>
                    )">Response</button>
                  <?php endif; ?>

                  <button class="del-btn" onclick="openConfirm(<?= (int) $lead['id'] ?>)">Delete</button>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </div>

</div>