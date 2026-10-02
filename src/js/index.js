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
        el.addEventListener('transitionend', function clearDelay() {
          el.style.transitionDelay = '0s';
          el.removeEventListener('transitionend', clearDelay);
        });
      });
    })();