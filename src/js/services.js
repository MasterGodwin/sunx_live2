// ══════════════════════════════════════
// SUN-X — Services Page Interactions
// (navbar + drawer handled by comman.js;
//  this file only handles scroll reveals
//  for the services-page sections)
// ══════════════════════════════════════

// Generic reveal-on-scroll for anim-left / anim-right / anim-up
const srvAnimEls = document.querySelectorAll('.anim-left, .anim-right, .anim-up');
const srvAnimObs = new IntersectionObserver(entries => {
  entries.forEach(e => e.target.classList.toggle('in-view', e.isIntersecting));
}, { threshold: 0, rootMargin: '0px 0px -60px 0px' });
srvAnimEls.forEach(el => srvAnimObs.observe(el));

// Core service cards — staggered reveal
const srvCards = document.querySelectorAll('.srv-card');
const srvCardObs = new IntersectionObserver(entries => {
  entries.forEach(e => {
    if (e.isIntersecting) {
      e.target.classList.add('in-view');
      srvCardObs.unobserve(e.target);
    }
  });
}, { threshold: 0, rootMargin: '0px 0px -40px 0px' });

srvCards.forEach((card, i) => {
  card.style.opacity = '0';
  card.style.transform = 'translateY(32px)';
  card.style.filter = 'blur(4px)';
  card.style.transition = `opacity 0.7s cubic-bezier(.22,1,.36,1) ${i * 0.12}s,
                            transform 0.7s cubic-bezier(.22,1,.36,1) ${i * 0.12}s,
                            filter 0.7s ease ${i * 0.12}s`;
  srvCardObs.observe(card);
});

document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.srv-card.in-view').forEach(card => {
    card.style.opacity = '1';
    card.style.transform = 'none';
    card.style.filter = 'none';
  });
});

// Patch: toggle actual visual state via class instead of relying purely on inline styles
const srvCardStyleObs = new MutationObserver(mutations => {
  mutations.forEach(m => {
    const el = m.target;
    if (el.classList.contains('in-view')) {
      el.style.opacity = '1';
      el.style.transform = 'none';
      el.style.filter = 'none';
    }
  });
});
srvCards.forEach(card => srvCardStyleObs.observe(card, { attributes: true, attributeFilter: ['class'] }));

// Certification cards — staggered reveal (anim-up already handles fade,
// this just adds the stagger delay programmatically as a fallback)
document.querySelectorAll('.srv-cert-card.anim-up').forEach((el, i) => {
  if (!el.style.transitionDelay) el.style.transitionDelay = (i * 0.1) + 's';
});

// Process steps — staggered reveal
document.querySelectorAll('.srv-proc-step').forEach((el, i) => {
  el.classList.add('anim-up');
  el.style.transitionDelay = (i * 0.14) + 's';
  srvAnimObs.observe(el);
});
// ══════════════════════════════════════
// CERTIFICATE LIGHTBOX
// ══════════════════════════════════════
(function () {
  const lightbox = document.getElementById('certLightbox');
  const lbImg    = document.getElementById('certLbImg');
  const lbClose  = document.getElementById('certLbClose');

  document.querySelectorAll('.srv-cert-img-card').forEach(card => {
    card.addEventListener('click', () => {
      const src = card.dataset.src;
      const alt = card.dataset.alt;
      lbImg.src = src;
      lbImg.alt = alt;
      lightbox.classList.add('open');
      document.body.style.overflow = 'hidden';
    });
  });

  function closeLb() {
    lightbox.classList.remove('open');
    document.body.style.overflow = '';
    setTimeout(() => { lbImg.src = ''; }, 300);
  }

  lbClose.addEventListener('click', closeLb);
  lightbox.addEventListener('click', e => { if (e.target === lightbox) closeLb(); });
  document.addEventListener('keydown', e => { if (e.key === 'Escape') closeLb(); });
})();

// ══════════════════════════════════════
// CERTIFICATE CAROUSEL
// ══════════════════════════════════════
(function () {
  const track    = document.getElementById('certTrack');
  const viewport = document.getElementById('certViewport');
  const prevBtn  = document.getElementById('certPrev');
  const nextBtn  = document.getElementById('certNext');
  const dotsWrap = document.getElementById('certDots');
  const slides   = Array.from(track.querySelectorAll('.cert-car-slide'));
  let current = 0;

  function getVisible() {
    const w = window.innerWidth;
    if (w <= 700)  return 1;
    if (w <= 1024) return 2;
    return 3;
  }

  function buildDots() {
    dotsWrap.innerHTML = '';
    const total = slides.length - getVisible() + 1;
    for (let i = 0; i < total; i++) {
      const d = document.createElement('button');
      d.className = 'cert-car-dot' + (i === current ? ' active' : '');
      d.addEventListener('click', () => goTo(i));
      dotsWrap.appendChild(d);
    }
  }

  function goTo(index) {
    const vis = getVisible();
    const max = slides.length - vis;
    current = Math.max(0, Math.min(index, max));

    const slideW = slides[0].offsetWidth + 16; // gap = 1.2rem ≈ 16px
    track.style.transform = `translateX(-${current * slideW}px)`;

    dotsWrap.querySelectorAll('.cert-car-dot').forEach((d, i) =>
      d.classList.toggle('active', i === current)
    );
    prevBtn.disabled = current === 0;
    nextBtn.disabled = current >= max;
  }

  prevBtn.addEventListener('click', () => goTo(current - 1));
  nextBtn.addEventListener('click', () => goTo(current + 1));
  window.addEventListener('resize', () => { buildDots(); goTo(current); });

  // Touch swipe
  let tx = 0;
  track.addEventListener('touchstart', e => { tx = e.changedTouches[0].screenX; }, { passive: true });
  track.addEventListener('touchend', e => {
    const diff = tx - e.changedTouches[0].screenX;
    if (Math.abs(diff) > 40) goTo(diff > 0 ? current + 1 : current - 1);
  }, { passive: true });

  // Lightbox on slide click
  const lightbox = document.getElementById('certLightbox');
  const lbImg    = document.getElementById('certLbImg');
  const lbClose  = document.getElementById('certLbClose');

  slides.forEach(slide => {
    slide.addEventListener('click', () => {
      lbImg.src = slide.dataset.src;
      lbImg.alt = slide.dataset.alt;
      lightbox.classList.add('open');
      document.body.style.overflow = 'hidden';
    });
  });

  function closeLb() {
    lightbox.classList.remove('open');
    document.body.style.overflow = '';
    setTimeout(() => { lbImg.src = ''; }, 300);
  }

  if (lbClose) lbClose.addEventListener('click', closeLb);
  if (lightbox) lightbox.addEventListener('click', e => { if (e.target === lightbox) closeLb(); });
  document.addEventListener('keydown', e => { if (e.key === 'Escape') closeLb(); });

  buildDots();
  goTo(0);
})();