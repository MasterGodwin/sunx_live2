// ══════════════════════════════════════
// SLIDER
// ══════════════════════════════════════

let currentSlide = 0, isPaused = false, slideTimer;
const slides = document.querySelectorAll('.slide');
const tabs = document.querySelectorAll('.tab');
const pauseBtn = document.getElementById('pauseBtn');
const slidesWrapper = document.getElementById('slidesWrapper');

function animateSlideText(slide) {
  const c = slide.querySelector('.slide-content');
  if (!c) return;
  c.classList.remove('text-animate');
  requestAnimationFrame(() => {
    requestAnimationFrame(() => {
      c.classList.add('text-animate');
    });
  });
}

function showSlide(index) {
  if (!slides.length) return;
  slides.forEach((s, i) => {
    s.classList.toggle('active', i === index);
    if (i === index) setTimeout(() => animateSlideText(s), 200);
    else { const c = s.querySelector('.slide-content'); if (c) c.classList.remove('text-animate'); }
  });
  tabs.forEach((t, i) => t.classList.toggle('active', i === index));
  currentSlide = index;
}

function startAutoSlide() {
  if (!slides.length) return;
  clearInterval(slideTimer);
  slideTimer = setInterval(() => { if (!isPaused) showSlide((currentSlide + 1) % slides.length); }, 5000);
}

if (tabs.length) {
  tabs.forEach((tab, i) => tab.addEventListener('click', () => { showSlide(i); startAutoSlide(); }));
}

if (pauseBtn) {
  pauseBtn.addEventListener('click', () => {
    isPaused = !isPaused;
    pauseBtn.textContent = isPaused ? '▶' : '⏸';
  });
}

if (slides.length) {
  document.addEventListener('keydown', e => {
    if (e.key === 'ArrowRight') { showSlide((currentSlide + 1) % slides.length); startAutoSlide(); }
    if (e.key === 'ArrowLeft') { showSlide((currentSlide - 1 + slides.length) % slides.length); startAutoSlide(); }
  });
}

if (slidesWrapper && slides.length) {
  let touchStartX = 0;
  slidesWrapper.addEventListener('touchstart', e => { touchStartX = e.changedTouches[0].screenX; }, { passive: true });
  slidesWrapper.addEventListener('touchend', e => {
    const diff = touchStartX - e.changedTouches[0].screenX;
    if (Math.abs(diff) > 50) { showSlide(diff > 0 ? (currentSlide + 1) % slides.length : (currentSlide - 1 + slides.length) % slides.length); startAutoSlide(); }
  }, { passive: true });
}

if (slides.length) {
  showSlide(0);
  startAutoSlide();
}

// ══════════════════════════════════════
// STAT COUNTER
// ══════════════════════════════════════
const countEls = document.querySelectorAll('[data-count]');
const statsSection = document.getElementById('statsSection');
let countStarted = false;

if (statsSection && countEls.length) {
  const statsObserver = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (entry.isIntersecting && !countStarted) {
        countStarted = true;
        countEls.forEach(el => {
          const target = parseInt(el.getAttribute('data-count'));
          let count = 0;
          const inc = target / 60;
          const timer = setInterval(() => {
            count += inc;
            if (count >= target) { count = target; clearInterval(timer); }
            el.textContent = Math.floor(count);
          }, 1400 / 60);
        });
      }
    });
  }, { threshold: 0, rootMargin: '0px 0px -50px 0px' });
  statsObserver.observe(statsSection);
}

// ══════════════════════════════════════
// SCROLL ANIMATIONS
// ══════════════════════════════════════
const aboutEls = document.querySelectorAll('.anim-left, .anim-right, .anim-up');
if (aboutEls.length) {
  const aboutObserver = new IntersectionObserver(entries => {
    entries.forEach(e => e.target.classList.toggle('in-view', e.isIntersecting));
  }, { threshold: 0.15 });
  aboutEls.forEach(el => aboutObserver.observe(el));
}

const valuedSection = document.getElementById('valuedSection');
if (valuedSection) {
  const valuedObserver = new IntersectionObserver(entries => {
    entries.forEach(e => e.target.classList.toggle('in-view', e.isIntersecting));
  }, { threshold: 0.08 });
  valuedObserver.observe(valuedSection);
}

const videoEls = document.querySelectorAll('.va-top, .va-thumb');
if (videoEls.length) {
  const videoObserver = new IntersectionObserver(entries => {
    entries.forEach(e => e.target.classList.toggle('in-view', e.isIntersecting));
  }, { threshold: 0.12 });
  videoEls.forEach(el => videoObserver.observe(el));
}

const advCardEls = document.querySelectorAll('#advCards .adv-card');
if (advCardEls.length) {
  const advObserver = new IntersectionObserver(entries => {
    entries.forEach(e => e.target.classList.toggle('in-view', e.isIntersecting));
  }, { threshold: 0, rootMargin: '0px 0px -80px 0px' });
  advCardEls.forEach(el => advObserver.observe(el));
}

const advLeftContent = document.querySelector('.adv-left-content');
if (advLeftContent) {
  const advLeftObserver = new IntersectionObserver(entries => {
    entries.forEach(e => e.target.classList.toggle('in-view', e.isIntersecting));
  }, { threshold: 0, rootMargin: '0px 0px -80px 0px' });
  advLeftObserver.observe(advLeftContent);
}

// ══════════════════════════════════════
// PROJECTS SECTION SCROLL ANIMATIONS
// ══════════════════════════════════════
const projCardEls = document.querySelectorAll('#projCards .proj-card');
const projHeader = document.getElementById('projHeader');
if (projCardEls.length || projHeader) {
  const projObserver = new IntersectionObserver(entries => {
    entries.forEach(e => e.target.classList.toggle('in-view', e.isIntersecting));
  }, { threshold: 0, rootMargin: '0px 0px -80px 0px' });
  projCardEls.forEach(el => projObserver.observe(el));
  if (projHeader) projObserver.observe(projHeader);
}

// ══════════════════════════════════════
// NEWS & PLANTS SCROLL ANIMATIONS
// ══════════════════════════════════════
const pageObserver = new IntersectionObserver(entries => {
  entries.forEach(e => e.target.classList.toggle('in-view', e.isIntersecting));
}, { threshold: 0, rootMargin: '0px 0px -80px 0px' });

['newsHeader', 'newsFeatured', 'plantsLeft',
  'plantsImgMain', 'plantsText', 'plantsImgSecondary', 'plantsBottomText'
].forEach(id => {
  const el = document.getElementById(id);
  if (el) pageObserver.observe(el);
});

// ══════════════════════════════════════
// SX FEATURES SECTION SCROLL ANIMATIONS
// ══════════════════════════════════════
const sxHeader = document.querySelector('.sx-header');
const sxCardEls = document.querySelectorAll('.sx-card');
if (sxHeader || sxCardEls.length) {
  const sxObserver = new IntersectionObserver(entries => {
    entries.forEach(e => e.target.classList.toggle('in-view', e.isIntersecting));
  }, { threshold: 0, rootMargin: '0px 0px -80px 0px' });

  if (sxHeader) sxObserver.observe(sxHeader);

  sxCardEls.forEach((el, i) => {
    el.style.transitionDelay = (i * 0.13) + 's';
    sxObserver.observe(el);
  });
}

// ── Experience banner, Features, Contact ──
['expInner', 'featHeader', 'feat1', 'feat2', 'feat3'].forEach(id => {
  const el = document.getElementById(id);
  if (el) pageObserver.observe(el);
});