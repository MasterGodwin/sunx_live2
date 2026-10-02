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