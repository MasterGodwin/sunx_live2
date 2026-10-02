<?php
require_once __DIR__ . '/admin_panel/config.php';

$pdo = getDB();
$stmt = $pdo->query(
  'SELECT * FROM jobs WHERE deleted_at = 0 ORDER BY id ASC'
);
$jobs = $stmt->fetchAll();

$openCount = count(array_filter($jobs, fn($j) => (int) $j['status'] === 1));

$typeMap = [1 => 'Full Time', 2 => 'Part Time', 3 => 'Contract', 4 => 'Internship'];
$statusMap = [1 => 'Hiring Now', 2 => 'In Active'];
$countryMap = [1 => 'India', 2 => 'Dubai'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php include 'top-includes.php' ?>
</head>

<body>

  <?php include 'header.php' ?>

  <section class="about-hero6" id="hero">
    <div class="about-hero-overlay"></div>
    <div class="about-hero-content">
      <div class="slide-eyebrow">
        <div class="eyebrow-line"></div>
        <span class="eyebrow-text">
          <a href="index.php" style="color:inherit;text-decoration:none;">Home</a>
          &nbsp;·&nbsp;
          <a href="careers.php" style="color:inherit;text-decoration:none;">Careers</a>
        </span>
      </div>
      <h1 class="about-hero-title">JOIN THE <span class="red">TEAM</span></h1>
      <p class="about-hero-subtitle">Build a meaningful career at SUN-X Concrete where passion, commitment and
        excellence come together to create structures that last a lifetime.</p>
    </div>
  </section>

  <!-- ── OPEN VACANCIES ── -->
  <!-- <section class="vacancy-section" id="vacancySection">
    <div class="vacancy-inner">

      <div class="vacancy-left" id="vacancyLeft" style="max-width:780px;">
        <div class="vacancy-left-top">
          <span class="vacancy-tag">Open Vacancies</span>
          <h2 class="vacancy-title">Roles That Challenge &amp; <span style="color: #fec403;">Reward</span></h2>
          <p class="vacancy-desc">
            We at SUN-X Concrete offer a diverse range of exciting and challenging roles in a rewarding work environment
            where individuals can aspire to grow with us — realizing their full potential.
          </p>
        </div>
        <div class="vacancy-left-bottom">
          <div class="vacancy-quote-accent"></div>
          <p class="vacancy-quote-text">
            We're looking for true individuals. People with the courage to take chances. Who understand that
            making a difference takes passion, patience, and persistence.
          </p>
          <p class="vacancy-quote-sub">
            We honor our word. We do what we say, when we say we're going to do it. No excuses. We bring plans to life
            with grit and determination to execute first-class quality work.
          </p>
        </div>
      </div>

    </div>
  </section> -->

  <!-- ── CURRENT OPENINGS ── -->
  <section class="openings-section" id="openings">
    <div class="openings-inner">

      <div class="openings-header" id="openingsHeader">
        <div>
          <div class="openings-tag">Now Hiring</div>
          <h2 class="openings-title">Current <span style="color: #fec403;">Openings</span></h2>
        </div>
        <div class="openings-count">
          <span><?= $openCount ?></span>
          Open Position<?= $openCount !== 1 ? 's' : '' ?>
        </div>
      </div>

      <!-- ── Two-column split: India | UAE ── -->
      <div class="openings-split">

        <!-- INDIA -->
        <div class="openings-col">
          <div class="openings-col-label">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
              stroke-linejoin="round" style="width:15px;height:15px;">
              <circle cx="12" cy="10" r="3" />
              <path d="M12 2a8 8 0 0 0-8 8c0 5.25 8 12 8 12s8-6.75 8-12a8 8 0 0 0-8-8z" />
            </svg>
            India
          </div>
          <div class="openings-list" id="openingsListIndia">
            <?php
            $indiaJobs = array_filter($jobs, fn($j) => (int) ($j['country'] ?? 1) !== 2);
            $indiaJobs = array_values($indiaJobs);
            ?>
            <?php if (empty($indiaJobs)): ?>
              <p class="openings-empty">No India openings at the moment.</p>
            <?php else: ?>
              <?php foreach ($indiaJobs as $i => $job):
                $num = str_pad($i + 1, 2, '0', STR_PAD_LEFT);
                $typeName = $typeMap[(int) $job['employment_type']] ?? 'Full Time';
                $statusName = $statusMap[(int) $job['status']] ?? 'Hiring Now';
                $isHiring = (int) $job['status'] === 1;
                ?>
                <div class="opening-card" id="oc<?= $i + 1 ?>">
                  <div class="opening-card-bg-num"><?= $num ?></div>
                  <div class="opening-card-header">
                    <div class="opening-info">
                      <div class="opening-title"><?= htmlspecialchars($job['job_title']) ?></div>
                      <div class="opening-meta">
                        <?php if ($isHiring): ?><span class="opening-badge red">Hiring Now</span><?php else: ?><span
                            class="opening-badge"><?= htmlspecialchars($statusName) ?></span><?php endif; ?>
                        <span class="opening-badge"><?= htmlspecialchars($typeName) ?></span>
                        <?php if ($job['location']): ?><span
                            class="opening-badge"><?= htmlspecialchars($job['location']) ?></span><?php endif; ?>
                      </div>
                    </div>
                    <div class="opening-arrow">
                      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                        stroke-linejoin="round">
                        <line x1="12" y1="5" x2="12" y2="19" />
                        <polyline points="19 12 12 19 5 12" />
                      </svg>
                    </div>
                  </div>
                  <div class="opening-panel">
                    <div class="op-divider"></div>
                    <div class="opening-panel-inner">
                      <div>
                        <div class="op-meta-row">
                          <?php if ($job['location']): ?>
                            <span class="op-meta-chip"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                                <circle cx="12" cy="10" r="3" />
                              </svg><?= htmlspecialchars($job['location']) ?></span>
                          <?php endif; ?>
                          <?php if ($job['experience_required'] && $job['experience_required'] !== '—'): ?>
                            <span class="op-meta-chip"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10" />
                                <polyline points="12 6 12 12 16 14" />
                              </svg><?= htmlspecialchars($job['experience_required']) ?> Experience</span>
                          <?php endif; ?>
                          <span class="op-meta-chip"><?= htmlspecialchars($typeName) ?></span>
                        </div>
                        <div class="op-desc-label">Job Description</div>
                        <p class="op-desc-text"><?= nl2br(htmlspecialchars($job['job_description'])) ?></p>
                      </div>
                      <?php if ($isHiring): ?>
                        <button class="op-apply-btn" data-job-title="<?= htmlspecialchars($job['job_title']) ?>">
                          Apply Now
                          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                            stroke-linejoin="round">
                            <line x1="5" y1="12" x2="19" y2="12" />
                            <polyline points="12 5 19 12 12 19" />
                          </svg>
                        </button>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php endif; ?>
          </div>
        </div>

        <!-- UAE -->
        <div class="openings-col">
          <div class="openings-col-label">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
              stroke-linejoin="round" style="width:15px;height:15px;">
              <circle cx="12" cy="10" r="3" />
              <path d="M12 2a8 8 0 0 0-8 8c0 5.25 8 12 8 12s8-6.75 8-12a8 8 0 0 0-8-8z" />
            </svg>
            UAE
          </div>
          <div class="openings-list" id="openingsListUAE">
            <?php
            $uaeJobs = array_filter($jobs, fn($j) => (int) ($j['country'] ?? 0) === 2);
            $uaeJobs = array_values($uaeJobs);
            ?>
            <?php if (empty($uaeJobs)): ?>
              <p class="openings-empty">No UAE openings at the moment.</p>
            <?php else: ?>
              <?php foreach ($uaeJobs as $i => $job):
                $num = str_pad($i + 1, 2, '0', STR_PAD_LEFT);
                $typeName = $typeMap[(int) $job['employment_type']] ?? 'Full Time';
                $statusName = $statusMap[(int) $job['status']] ?? 'Hiring Now';
                $isHiring = (int) $job['status'] === 1;
                ?>
                <div class="opening-card" id="uae-oc<?= $i + 1 ?>">
                  <div class="opening-card-bg-num"><?= $num ?></div>
                  <div class="opening-card-header">
                    <div class="opening-info">
                      <div class="opening-title"><?= htmlspecialchars($job['job_title']) ?></div>
                      <div class="opening-meta">
                        <?php if ($isHiring): ?><span class="opening-badge red">Hiring Now</span><?php else: ?><span
                            class="opening-badge"><?= htmlspecialchars($statusName) ?></span><?php endif; ?>
                        <span class="opening-badge"><?= htmlspecialchars($typeName) ?></span>
                        <?php if ($job['location']): ?><span
                            class="opening-badge"><?= htmlspecialchars($job['location']) ?></span><?php endif; ?>
                      </div>
                    </div>
                    <div class="opening-arrow">
                      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                        stroke-linejoin="round">
                        <line x1="12" y1="5" x2="12" y2="19" />
                        <polyline points="19 12 12 19 5 12" />
                      </svg>
                    </div>
                  </div>
                  <div class="opening-panel">
                    <div class="op-divider"></div>
                    <div class="opening-panel-inner">
                      <div>
                        <div class="op-meta-row">
                          <?php if ($job['location']): ?>
                            <span class="op-meta-chip"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                                <circle cx="12" cy="10" r="3" />
                              </svg><?= htmlspecialchars($job['location']) ?></span>
                          <?php endif; ?>
                          <?php if ($job['experience_required'] && $job['experience_required'] !== '—'): ?>
                            <span class="op-meta-chip"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10" />
                                <polyline points="12 6 12 12 16 14" />
                              </svg><?= htmlspecialchars($job['experience_required']) ?> Experience</span>
                          <?php endif; ?>
                          <span class="op-meta-chip"><?= htmlspecialchars($typeName) ?></span>
                        </div>
                        <div class="op-desc-label">Job Description</div>
                        <p class="op-desc-text"><?= nl2br(htmlspecialchars($job['job_description'])) ?></p>
                      </div>
                      <?php if ($isHiring): ?>
                        <button class="op-apply-btn" data-job-title="<?= htmlspecialchars($job['job_title']) ?>">
                          Apply Now
                          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                            stroke-linejoin="round">
                            <line x1="5" y1="12" x2="19" y2="12" />
                            <polyline points="12 5 19 12 12 19" />
                          </svg>
                        </button>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php endif; ?>



          </div>
        </div>

      </div><!-- /openings-split -->
    </div>
  </section>

  <section class="openings-section" id="openings">
    <!-- ── Upload Resume CTA (below UAE jobs) ── -->
    <div class="uae-upload-cta">
      <div class="uae-upload-cta-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
          stroke-linejoin="round">
          <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
          <polyline points="17 8 12 3 7 8" />
          <line x1="12" y1="3" x2="12" y2="15" />
        </svg>
      </div>
      <div>
        <div class="uae-upload-cta-title">Don't see your role?</div>
        <div class="uae-upload-cta-sub">Upload your resume for future India and UAE opportunities.</div>
      </div>
      <button class="uae-upload-btn" id="uaeUploadBtn">
        Upload Resume
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
          stroke-linejoin="round">
          <line x1="5" y1="12" x2="19" y2="12" />
          <polyline points="12 5 19 12 12 19" />
        </svg>
      </button>
    </div>
  </section>

  <!-- ── PEOPLE FIRST ── -->
  <section class="people-section" id="peopleSection">
    <div class="people-inner" id="peopleInner">
      <div class="people-deco">
        <svg viewBox="0 0 120 80" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M10 70 Q40 10 80 30 Q110 50 115 15" stroke="#1a1a1a" stroke-width="1.5" fill="none"
            stroke-linecap="round" />
          <polygon points="108,8 120,18 106,20" fill="#1a1a1a" />
          <line x1="30" y1="75" x2="90" y2="75" stroke="#1a1a1a" stroke-width="1" opacity="0.3" />
        </svg>
      </div>
      <div class="people-editorial">
        <p class="people-editorial-main">Here, We Put People First</p>
        <p class="people-editorial-fade">We lift up our co-workers, listen to our clients and work hard to support our
          families. We honor our word. We do what we say, when we say we're going to do it. No excuses. We bring plans
          to life with grit and determination to execute first-class quality work. And we achieve all this one simple
          way: By recruiting the best and brightest in the industry who share our ideals, principles and commitment. We
          seek out individuals for every level of our company who will work – and live – the SUN-X Way.</p>
      </div>
    </div>
  </section>

  <!-- ── WHY JOIN SUN-X ── -->
  <section class="why-section" id="whySection">
    <div class="why-inner">
      <div class="why-header" id="whyHeader">
        <div class="why-eyebrow">
          <span class="why-eyebrow-line"></span>
          Why Sun-X
          <span class="why-eyebrow-line"></span>
        </div>
        <h2 class="why-title">Why Join <span style="color:#fec403;">SUN-X?</span></h2>
      </div>
      <div class="why-grid">
        <div class="why-card" id="wc1">
          <div class="why-card-title">Learning and Development</div>
          <div class="why-card-desc">Structured training programmes, mentorship from industry veterans with 100+ years
            of combined experience, and continuous growth opportunities across all levels.</div>
          <div class="why-card-bar">
            <div class="why-card-bar-fill" style="--bar-w:90%"></div>
          </div>
        </div>
        <div class="why-card" id="wc2">
          <div class="why-card-title">Benefits &amp; Compensation</div>
          <div class="why-card-desc">Competitive compensation packages, comprehensive health benefits, performance
            bonuses, and a rewarding work environment built for long-term careers.</div>
          <div class="why-card-bar">
            <div class="why-card-bar-fill" style="--bar-w:85%"></div>
          </div>
        </div>
        <div class="why-card" id="wc3">
          <div class="why-card-title">The Variety &amp; Complexity</div>
          <div class="why-card-desc">From high-rise residential to mega infrastructure work on diverse, challenging
            structures across Tamil Nadu, Karnataka and Andhra Pradesh, gaining unmatched exposure.</div>
          <div class="why-card-bar">
            <div class="why-card-bar-fill" style="--bar-w:95%"></div>
          </div>
        </div>
        <div class="why-card" id="wc4">
          <div class="why-card-title">Family Atmosphere &amp; Leadership</div>
          <div class="why-card-desc">A leadership team that knows your name. A culture where colleagues feel like
            family, decisions are transparent, and every contribution is recognized and celebrated.</div>
          <div class="why-card-bar">
            <div class="why-card-bar-fill" style="--bar-w:92%"></div>
          </div>
        </div>
      </div>
      <div class="why-cta-block" id="whyCta">
        <div>
          <div class="why-cta-text">Ready to build something <span>meaningful?</span></div>
          <div class="why-cta-sub">Explore our open roles and take the first step towards a rewarding career at SUN-X.
          </div>
        </div>
        <a href="#openings" class="why-cta-btn">
          View All Openings
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
            stroke-linejoin="round">
            <line x1="5" y1="12" x2="19" y2="12" />
            <polyline points="12 5 19 12 12 19" />
          </svg>
        </a>
      </div>
    </div>
  </section>

  <!-- ── APPLICATION MODAL ── -->
  <div class="apply-modal-overlay" id="applyModal">
    <div class="apply-modal-box">
      <div class="apply-modal-header">
        <div>
          <div class="apply-modal-eyebrow">Apply Now</div>
          <h3 class="apply-modal-title" id="applyModalTitle">Position</h3>
        </div>
        <button class="apply-modal-close" id="applyModalClose">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
            stroke-linejoin="round">
            <line x1="18" y1="6" x2="6" y2="18" />
            <line x1="6" y1="6" x2="18" y2="18" />
          </svg>
        </button>
      </div>
      <div class="apply-modal-body">
        <form class="app-form" id="applicationForm">
          <div class="app-form-row">
            <div class="app-field">
              <label class="app-label" for="appFirstName">First Name</label>
              <input class="app-input" id="appFirstName" name="first_name" type="text" placeholder="e.g. Arjun" />
            </div>
            <div class="app-field">
              <label class="app-label" for="appSecondName">Last Name</label>
              <input class="app-input" id="appSecondName" name="second_name" type="text" placeholder="e.g. Kumar" />
            </div>
            <div class="app-field">
              <label class="app-label" for="appEmail">Email Address</label>
              <input class="app-input" id="appEmail" name="email" type="email" placeholder="you@email.com" />
            </div>
            <div class="app-field">
              <label class="app-label" for="appPhone">Phone Number</label>
              <input class="app-input" id="appPhone" name="phone" type="tel" placeholder="+91 98765 43210" />
            </div>
          </div>
          
            <div class="app-field">
              <label class="app-label">Position Applied For</label>
              <div class="app-position-locked" id="appPositionDisplay">
                <span id="appPositionText">Select a role</span>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                  stroke-linejoin="round">
                  <rect x="5" y="11" width="14" height="10" rx="2" />
                  <path d="M8 11V7a4 4 0 0 1 8 0v4" />
                </svg>
              </div>
              <input type="hidden" id="appPosition" name="position" value="" />
            </div>
        </form>

        <div class="upload-box" id="uploadBox">
          <input type="file" id="cvFile" name="cv" accept=".pdf,.doc,.docx" style="display:none;" />
          <div class="upload-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
              stroke-linejoin="round">
              <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
              <polyline points="17 8 12 3 7 8" />
              <line x1="12" y1="3" x2="12" y2="15" />
            </svg>
          </div>
          <div class="upload-title">Drop your CV here</div>
          <div class="upload-sub"><span>Click to browse</span> or drag &amp; drop</div>
          <div class="upload-types">
            <span class="upload-type-badge">PDF</span>
            <span class="upload-type-badge">DOC</span>
            <span class="upload-type-badge">DOCX</span>
          </div>
          <div class="upload-filename" id="uploadFilename" style="display:none;"></div>
        </div>

        <button class="app-submit" type="button" id="submitApplicationBtn">
          Submit Application
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
            stroke-linejoin="round">
            <line x1="5" y1="12" x2="19" y2="12" />
            <polyline points="12 5 19 12 12 19" />
          </svg>
        </button>
        <p id="formMsg" style="display:none;margin-top:0.8rem;font-size:0.8rem;font-weight:600;text-align:center;"></p>
      </div>
    </div>
  </div>

  <!-- ── PAGE SUBMIT LOADER ── -->
  <div class="page-loader-overlay" id="pageLoader">
    <div class="page-loader-box">
      <div class="page-loader-ring"></div>
      <p class="page-loader-title">Submitting your application…</p>
      <p class="page-loader-sub">Please wait, do not close this page.</p>
      <div class="page-loader-bar-wrap">
        <div class="page-loader-bar" id="pageLoaderBar"></div>
      </div>
    </div>
  </div>

  <!-- ── SUCCESS POPUP ── -->
  <div class="success-overlay" id="successOverlay">
    <div class="success-popup">
      <div class="success-tick-wrap">
        <svg class="success-tick-svg" viewBox="0 0 24 24">
          <polyline points="4 12 9 17 20 6" />
        </svg>
      </div>
      <div class="success-popup-title">Application Submitted!</div>
      <div class="success-popup-sub">Thank you for applying.<br>We'll review your CV and reach out to you soon.</div>
      <button class="success-popup-close" id="successClose">Close</button>
    </div>
  </div>

  <?php include 'footer.php' ?>

  <!-- ── SCRIPTS ── -->
  <script type="module" src="src/js/comman.js" defer></script>
  <script src="src/js/careers.js"></script>

</body>

</html>