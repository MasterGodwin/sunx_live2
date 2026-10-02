
// ══════════════════════════════════════
// PRODUCTS CAROUSEL
// ══════════════════════════════════════
(function () {
    const track = document.getElementById('prodTrack');
    const prevBtn = document.getElementById('prodPrev');
    const nextBtn = document.getElementById('prodNext');
    const dotsWrap = document.getElementById('prodDots');
    const cards = Array.from(track.querySelectorAll('.prod-card'));
    let current = 0;

    function getVisible() {
        const w = window.innerWidth;
        if (w >= 1100) return 3;
        if (w >= 680) return 2;
        return 1;
    }

    function buildDots() {
        dotsWrap.innerHTML = '';
        const total = cards.length - getVisible() + 1;
        for (let i = 0; i < total; i++) {
            const d = document.createElement('button');
            d.className = 'prod-dot' + (i === 0 ? ' active' : '');
            d.setAttribute('aria-label', `Go to slide ${i + 1}`);   
            d.setAttribute('aria-current', i === 0 ? 'true' : 'false');
            d.addEventListener('click', () => goTo(i));
            dotsWrap.appendChild(d);
        }
    }

    function goTo(index) {
        const vis = getVisible();
        const max = cards.length - vis;
        current = Math.max(0, Math.min(index, max));
        const cardWidth = cards[0].offsetWidth + parseInt(getComputedStyle(track).gap || '0');
        track.style.transform = `translateX(-${current * cardWidth}px)`;
        document.querySelectorAll('.prod-dot').forEach((d, i) => d.classList.toggle('active', i === current));
    }

    prevBtn.addEventListener('click', () => goTo(current - 1));
    nextBtn.addEventListener('click', () => goTo(current + 1));
    window.addEventListener('resize', () => { buildDots(); goTo(current); });
    buildDots();

    // Touch swipe
    let tx = 0;
    track.addEventListener('touchstart', e => { tx = e.changedTouches[0].screenX; }, { passive: true });
    track.addEventListener('touchend', e => {
        const diff = tx - e.changedTouches[0].screenX;
        if (Math.abs(diff) > 40) goTo(diff > 0 ? current + 1 : current - 1);
    }, { passive: true });

    // Section header animation
    const prodObs = new IntersectionObserver(entries => {
        entries.forEach(e => e.target.classList.toggle('in-view', e.isIntersecting));
    }, { threshold: 0, rootMargin: '0px 0px -60px 0px' });
    const ph = document.getElementById('productsHeader');
    if (ph) prodObs.observe(ph);
})();

// ══════════════════════════════════════
// CAPABILITIES CARDS ANIMATION
// ══════════════════════════════════════
(function () {
    const capObs = new IntersectionObserver(entries => {
        entries.forEach(e => e.target.classList.toggle('in-view', e.isIntersecting));
    }, { threshold: 0, rootMargin: '0px 0px -60px 0px' });
    document.querySelectorAll('.cap-index-card').forEach((el, i) => {
        el.style.transitionDelay = (i * 0.12) + 's';
        capObs.observe(el);
    });
    const ch = document.querySelector('.cap-index-header');
    if (ch) capObs.observe(ch);
})(); 