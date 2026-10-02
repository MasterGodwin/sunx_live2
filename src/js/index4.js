// ══════════════════════════════════════════════════════
// COMBINED & FIXED PAGE SCRIPTS — No variable conflicts
// Replaces: index.js + index2.js + inline page scripts
// comman.js is separate (navbar/drawer) — keep as-is
// ══════════════════════════════════════════════════════

(function () {

  // ── 1. FOOTER TOP SECTION ANIMATIONS (index.js) ──
  const topItems = document.querySelectorAll('.fx-top-item');
  const logoItems = document.querySelectorAll('.fx-logo-item');

  const fxObs = new IntersectionObserver(entries => {
    entries.forEach(e => {
      if (e.isIntersecting) {
        e.target.classList.add('fx-in');
        fxObs.unobserve(e.target);
      }
    });
  }, { threshold: 0, rootMargin: '0px 0px -30px 0px' });

  topItems.forEach((el, i) => {
    el.style.transitionDelay = (i * 0.08) + 's';
    fxObs.observe(el);
  });

  logoItems.forEach((el, i) => {
    el.style.transitionDelay = (i * 0.1) + 's';
    fxObs.observe(el);
  });

  // ── 2. FOOTER BOTTOM COLUMNS ANIMATIONS (index2.js) ──
  const fx2Cols = document.querySelectorAll('.fx2-col');
  const fx2Obs = new IntersectionObserver(entries => {
    entries.forEach(e => {
      if (e.isIntersecting) {
        e.target.classList.add('fx-in');
        fx2Obs.unobserve(e.target);
      }
    });
  }, { threshold: 0, rootMargin: '0px 0px -30px 0px' });

  fx2Cols.forEach((el, i) => {
    el.style.transitionDelay = (i * 0.1) + 's';
    fx2Obs.observe(el);
  });

  // ── 3. GENERAL SCROLL ANIMATIONS (was: const obs — now renamed pageObs) ──
  const pageObs = new IntersectionObserver(entries => {
    entries.forEach(e => e.target.classList.toggle('in-view', e.isIntersecting));
  }, { threshold: 0, rootMargin: '0px 0px -60px 0px' });

  document.querySelectorAll('.anim-left, .anim-right, .anim-up').forEach(el => pageObs.observe(el));

  const scLabelRow = document.getElementById('scLabelRow');
  if (scLabelRow) pageObs.observe(scLabelRow);

  // ── 4. SERVICE CARDS STAGGERED ANIMATIONS ──
  const svcCardObs = new IntersectionObserver(entries => {
    entries.forEach(e => e.target.classList.toggle('in-view', e.isIntersecting));
  }, { threshold: 0, rootMargin: '0px 0px -80px 0px' });

  ['scard1', 'scard2', 'scard3'].forEach((id, i) => {
    const el = document.getElementById(id);
    if (el) {
      el.style.transitionDelay = (i * 0.15) + 's';
      svcCardObs.observe(el);
    }
  });

  // ── 5. PROCESS STEPS STAGGERED ANIMATIONS ──
  document.querySelectorAll('.srv-proc-step').forEach((el, i) => {
    el.style.transitionDelay = (i * 0.14) + 's';
    pageObs.observe(el);
  });

  // ── 6. CTA SECTION ANIMATION ──
  const srvCta = document.getElementById('srvCta');
  if (srvCta) pageObs.observe(srvCta);

})();