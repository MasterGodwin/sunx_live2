    const obs = new IntersectionObserver(entries => {
      entries.forEach(e => e.target.classList.toggle('in-view', e.isIntersecting));
    }, { threshold: 0, rootMargin: '0px 0px -60px 0px' });

    document.querySelectorAll('.anim-left, .anim-right, .anim-up').forEach(el => obs.observe(el));

    const lbl = document.getElementById('tmLabel');
    if (lbl) obs.observe(lbl);

    const feat = document.getElementById('tmFeatured');
    if (feat) obs.observe(feat);

    const cardObs = new IntersectionObserver(entries => {
      entries.forEach(e => e.target.classList.toggle('in-view', e.isIntersecting));
    }, { threshold: 0, rootMargin: '0px 0px -60px 0px' });
    ['tmCard1', 'tmCard2', 'tmCard3', 'tmCard4'].forEach((id, i) => {
      const el = document.getElementById(id);
      if (el) { el.style.transitionDelay = (i * 0.12) + 's'; cardObs.observe(el); }
    });
