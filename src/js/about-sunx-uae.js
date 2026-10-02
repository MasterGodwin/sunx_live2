
    (function () {
      const topItems = document.querySelectorAll('.fx-top-item');
      const logoItems = document.querySelectorAll('.fx-logo-item');
      const fxObs = new IntersectionObserver(entries => {
        entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('fx-in'); fxObs.unobserve(e.target); } });
      }, { threshold: 0, rootMargin: '0px 0px -30px 0px' });
      topItems.forEach((el, i) => { el.style.transitionDelay = (i * 0.08) + 's'; fxObs.observe(el); });
      logoItems.forEach((el, i) => { el.style.transitionDelay = (i * 0.1) + 's'; fxObs.observe(el); });
    })();
  


    (function () {
      const cols = document.querySelectorAll('.fx2-col');
      const obs = new IntersectionObserver(entries => {
        entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('fx-in'); obs.unobserve(e.target); } });
      }, { threshold: 0, rootMargin: '0px 0px -30px 0px' });
      cols.forEach((el, i) => { el.style.transitionDelay = (i * 0.1) + 's'; obs.observe(el); });
    })();
  


    const animEls = document.querySelectorAll('.anim-left, .anim-right, .anim-up');
    const animObserver = new IntersectionObserver(entries => {
      entries.forEach(e => e.target.classList.toggle('in-view', e.isIntersecting));
    }, { threshold: 0, rootMargin: '0px 0px -60px 0px' });
    animEls.forEach(el => animObserver.observe(el));
