const slides = document.querySelectorAll('.ps-slide');
    const dots = document.querySelectorAll('.ps-dot');
    const ctr = document.getElementById('ctr');
    const total = slides.length;
    let cur = 0, timer;

    const pad = n => String(n).padStart(2, '0');

    function goTo(idx) {
      slides[cur].classList.remove('active');
      slides[cur].classList.add('out');
      dots[cur].classList.remove('active');
      const prev = cur;
      setTimeout(() => slides[prev].classList.remove('out'), 400);
      cur = (idx + total) % total;
      slides[cur].classList.add('active');
      dots[cur].classList.add('active');
      ctr.textContent = pad(cur + 1) + ' — ' + pad(total);
    }

    function resetAuto() { clearInterval(timer); timer = setInterval(() => goTo(cur + 1), 5000); }

    document.getElementById('prev').addEventListener('click', () => { goTo(cur - 1); resetAuto(); });
    document.getElementById('next').addEventListener('click', () => { goTo(cur + 1); resetAuto(); });
    dots.forEach(d => d.addEventListener('click', () => { goTo(+d.dataset.i); resetAuto(); }));

    resetAuto();
  

    const projObserver = new IntersectionObserver(entries => {
      entries.forEach(e => e.target.classList.toggle('in-view', e.isIntersecting));
    }, { threshold: 0, rootMargin: '0px 0px -80px 0px' });
    document.querySelectorAll('#projCards .proj-card').forEach(el => projObserver.observe(el));

    const projHeader = document.getElementById('projHeader');
    if (projHeader) projObserver.observe(projHeader);
  

    (function () {
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
    })();
  

    (function () {
      const cols = document.querySelectorAll('.fx2-col');
      const obs = new IntersectionObserver(entries => {
        entries.forEach(e => {
          if (e.isIntersecting) {
            e.target.classList.add('fx-in');
            obs.unobserve(e.target);
          }
        });
      }, { threshold: 0, rootMargin: '0px 0px -30px 0px' });
      cols.forEach((el, i) => {
        el.style.transitionDelay = (i * 0.1) + 's';
        obs.observe(el);
      });
    })();
  

    const animEls = document.querySelectorAll('.anim-left, .anim-right, .anim-up');

    const animObserver = new IntersectionObserver(entries => {
      entries.forEach(e => e.target.classList.toggle('in-view', e.isIntersecting));
    }, { threshold: 0, rootMargin: '0px 0px -60px 0px' });
    animEls.forEach(el => animObserver.observe(el));


    const valuedSection = document.getElementById('valuedSection');
    if (valuedSection) {
      const valuedObserver = new IntersectionObserver(entries => {
        entries.forEach(e => e.target.classList.toggle('in-view', e.isIntersecting));
      }, { threshold: 0.08 });
      valuedObserver.observe(valuedSection);
    }