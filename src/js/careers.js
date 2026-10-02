document.addEventListener('DOMContentLoaded', () => {

  // ── Footer animations ──
  (function () {
    const topItems  = document.querySelectorAll('.fx-top-item');
    const logoItems = document.querySelectorAll('.fx-logo-item');
    const fxObs = new IntersectionObserver(entries => {
      entries.forEach(e => {
        if (e.isIntersecting) { e.target.classList.add('fx-in'); fxObs.unobserve(e.target); }
      });
    }, { threshold: 0, rootMargin: '0px 0px -30px 0px' });
    topItems.forEach((el, i)  => { el.style.transitionDelay = (i * 0.08) + 's'; fxObs.observe(el); });
    logoItems.forEach((el, i) => { el.style.transitionDelay = (i * 0.1)  + 's'; fxObs.observe(el); });
  })();

  (function () {
    const cols = document.querySelectorAll('.fx2-col');
    const obs  = new IntersectionObserver(entries => {
      entries.forEach(e => {
        if (e.isIntersecting) { e.target.classList.add('fx-in'); obs.unobserve(e.target); }
      });
    }, { threshold: 0, rootMargin: '0px 0px -30px 0px' });
    cols.forEach((el, i) => { el.style.transitionDelay = (i * 0.1) + 's'; obs.observe(el); });
  })();

  // ── Opening card expand on click ──
  document.querySelectorAll('.opening-card').forEach(card => {
    card.addEventListener('click', function (e) {
      if (e.target.closest('.op-apply-btn')) return;
      const isExpanded = this.classList.contains('expanded');
      document.querySelectorAll('.opening-card').forEach(c => c.classList.remove('expanded'));
      if (!isExpanded) this.classList.add('expanded');
    });
  });

  // ── Apply Now button: open application modal ──
  function openApplyModal(jobTitle) {
    const modal = document.getElementById('applyModal');
    const titleEl = document.getElementById('applyModalTitle');
    const posInput = document.getElementById('appPosition');
    const posText = document.getElementById('appPositionText');
    const finalPosition = jobTitle || 'Other / General Application';

    if (titleEl) titleEl.textContent = jobTitle || 'General Application';
    if (posInput) posInput.value = finalPosition;
    if (posText) posText.textContent = finalPosition;

    if (modal) {
      modal.classList.add('active');
      document.body.style.overflow = 'hidden';
    }
  }

  function closeApplyModal() {
    const modal = document.getElementById('applyModal');
    if (modal) {
      modal.classList.remove('active');
      document.body.style.overflow = '';
    }
  }

  // Apply Now buttons on opening cards
  document.querySelectorAll('.op-apply-btn').forEach(btn => {
    btn.addEventListener('click', e => {
      e.stopPropagation();
      openApplyModal(btn.dataset.jobTitle || '');
    });
  });

  // UAE Upload Resume button
  const uaeUploadBtn = document.getElementById('uaeUploadBtn');
  if (uaeUploadBtn) {
    uaeUploadBtn.addEventListener('click', () => openApplyModal('Other / General Application'));
  }

  // Close modal
  const applyModalClose = document.getElementById('applyModalClose');
  if (applyModalClose) applyModalClose.addEventListener('click', closeApplyModal);
  const applyModal = document.getElementById('applyModal');
  if (applyModal) {
    applyModal.addEventListener('click', e => { if (e.target === applyModal) closeApplyModal(); });
  }
  document.addEventListener('keydown', e => {
    if (e.key === 'Escape') closeApplyModal();
  });

  // ── IntersectionObserver helper ──
  const makeObs = (threshold = 0, rootMargin = '0px 0px -60px 0px') =>
    new IntersectionObserver(entries => {
      entries.forEach(e => {
        if (e.isIntersecting) e.target.classList.add('in-view');
        else e.target.classList.remove('in-view');
      });
    }, { threshold, rootMargin });

  const obs = makeObs(0, '0px 0px -60px 0px');

  // Strip items
  ['cs1', 'cs2', 'cs3'].forEach((id, i) => {
    const el = document.getElementById(id); if (!el) return;
    el.style.transitionDelay = (i * 0.1) + 's'; obs.observe(el);
  });

  // Vacancy
  ['vacancyLeft', 'vacancyRight'].forEach(id => {
    const el = document.getElementById(id); if (el) obs.observe(el);
  });

  // Openings
  const openingsHeader = document.getElementById('openingsHeader');
  if (openingsHeader) obs.observe(openingsHeader);
  document.querySelectorAll('.opening-card').forEach((el, i) => {
    el.style.transitionDelay = (i * 0.12) + 's';
    obs.observe(el);
  });

  // People
  const peopleInner = document.getElementById('peopleInner');
  if (peopleInner) obs.observe(peopleInner);

  // Why
  const whyHeader = document.getElementById('whyHeader');
  if (whyHeader) obs.observe(whyHeader);
  ['wc1', 'wc2', 'wc3', 'wc4'].forEach((id, i) => {
    const el = document.getElementById(id); if (!el) return;
    el.style.transitionDelay = (i * 0.13) + 's'; obs.observe(el);
  });
  const whyCta = document.getElementById('whyCta');
  if (whyCta) obs.observe(whyCta);

  // ── File upload ──
  const cvFile         = document.getElementById('cvFile');
  const uploadBox      = document.getElementById('uploadBox');
  const uploadFilename = document.getElementById('uploadFilename');
  const formMsg        = document.getElementById('formMsg');
  const submitBtn      = document.getElementById('submitApplicationBtn');

  uploadBox.addEventListener('click', () => cvFile.click());

  uploadBox.addEventListener('dragover', e => {
    e.preventDefault();
    uploadBox.classList.add('dragover');
    uploadBox.style.borderColor = '#c0392b';
  });
  uploadBox.addEventListener('dragleave', () => {
    uploadBox.classList.remove('dragover');
    if (!cvFile.files.length) uploadBox.style.borderColor = '#e0e0e0';
  });
  uploadBox.addEventListener('drop', e => {
    e.preventDefault();
    uploadBox.classList.remove('dragover');
    if (e.dataTransfer.files[0]) handleFile(e.dataTransfer.files[0]);
  });
  cvFile.addEventListener('change', () => {
    if (cvFile.files[0]) handleFile(cvFile.files[0]);
  });

  function handleFile(file) {
    const allowed = [
      'application/pdf',
      'application/msword',
      'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
    ];
    if (!allowed.includes(file.type)) {
      showMsg('Only PDF, DOC, DOCX files are allowed.', 'error'); return;
    }
    if (file.size > 5 * 1024 * 1024) {
      showMsg('File size must be under 5MB.', 'error'); return;
    }
    uploadFilename.textContent    = '✓ ' + file.name;
    uploadFilename.style.color    = '#1a7a3f';
    uploadFilename.style.display  = 'block';
    uploadBox.style.borderColor   = '#1a7a3f';
    uploadBox.style.background    = 'rgba(26,122,63,0.03)';
    showMsg('', '');
  }

  // ── Submit Application (saves to DB + uploads CV) ──
  // ── Page loader helpers ──
  const pageLoader    = document.getElementById('pageLoader');
  const pageLoaderBar = document.getElementById('pageLoaderBar');

  function showLoader() {
    if (!pageLoader) return;
    pageLoaderBar.style.animation = 'none';
    pageLoaderBar.offsetHeight;
    pageLoaderBar.style.animation = '';
    pageLoader.classList.add('active');
    document.body.style.overflow = 'hidden';
  }

  function hideLoader() {
    if (!pageLoader) return;
    pageLoader.classList.remove('active');
    document.body.style.overflow = '';
  }

  function resetForm() {
    document.getElementById('appFirstName').value  = '';
    document.getElementById('appSecondName').value = '';
    document.getElementById('appEmail').value    = '';
    document.getElementById('appPhone').value    = '';
    document.getElementById('appPosition').value = '';
    const posTextReset = document.getElementById('appPositionText');
    if (posTextReset) posTextReset.textContent = 'Select a role';
    cvFile.value                 = '';
    uploadFilename.textContent   = '';
    uploadFilename.style.display = 'none';
    uploadBox.style.borderColor  = '#e0e0e0';
    uploadBox.style.background   = '';
  }

  // ── Success popup ──
  const successOverlay = document.getElementById('successOverlay');
  const successClose   = document.getElementById('successClose');

  function showSuccess() {
    hideLoader();
    showMsg('', '');
    resetForm();
    closeApplyModal();
    // Show popup
    successOverlay.classList.add('active');
    document.body.style.overflow = 'hidden';
  }

  function closeSuccessPopup() {
    successOverlay.classList.remove('active');
    document.body.style.overflow = '';
    submitBtn.innerHTML        = 'Submit Application <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>';
    submitBtn.style.background = '';
    submitBtn.disabled         = false;
  }

  if (successClose) successClose.addEventListener('click', closeSuccessPopup);
  if (successOverlay) {
    successOverlay.addEventListener('click', (e) => {
      if (e.target === successOverlay) closeSuccessPopup();
    });
  }
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && successOverlay && successOverlay.classList.contains('active')) {
      closeSuccessPopup();
    }
  });

  submitBtn.addEventListener('click', () => {
    const firstName  = document.getElementById('appFirstName').value.trim();
    const secondName = document.getElementById('appSecondName').value.trim();
    const email    = document.getElementById('appEmail').value.trim();
    const phone    = document.getElementById('appPhone').value.trim();
    const position = document.getElementById('appPosition').value;
    const file     = cvFile.files[0];

    if (!firstName || !secondName || !email || !position) {
      showMsg('Please fill in First Name, Second Name, Email and Position.', 'error'); return;
    }
    if (!file) {
      showMsg('Please upload your CV / Resume.', 'error'); return;
    }

    const formData = new FormData();
    formData.append('first_name', firstName);
    formData.append('second_name', secondName);
    formData.append('email', email);
    formData.append('phone', phone);
    formData.append('position', position);
    formData.append('cv', file);

    submitBtn.disabled = true;
    showLoader();

    fetch('apply_careers.php', { method: 'POST', body: formData })
      .then(res => res.json())
      .then(data => {
        if (!data.ok) throw new Error(data.message || 'Something went wrong.');
        // DB save + CV upload + admin notification email are all handled
        // server-side in apply_careers.php now (Zoho SMTP via PHPMailer).
        showSuccess();
      })
      .catch(err => {
        console.error('Application submit error:', err);
        hideLoader();
        submitBtn.innerHTML        = 'Failed — Try Again';
        submitBtn.style.background = '#c0392b';
        submitBtn.disabled         = false;
        showMsg(err.message || 'Something went wrong. Please try again.', 'error');
      });
  });

  function showMsg(text, type) {
    formMsg.style.display = text ? 'block' : 'none';
    formMsg.textContent   = text;
    formMsg.style.color   = type === 'error' ? '#c0392b' : '#1a7a3f';
  }

}); // end DOMContentLoaded