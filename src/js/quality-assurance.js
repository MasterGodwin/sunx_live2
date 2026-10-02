
        // Navbar
        const navbar = document.getElementById('navbar');
        const hero = document.getElementById('hero');
        let lastScrollY = window.scrollY, navTicking = false;
        let heroHeight = hero.offsetHeight;
        window.addEventListener('resize', () => { heroHeight = hero.offsetHeight; }, { passive: true });
        function updateNav() {
            const s = window.scrollY;
            navbar.classList.toggle('nav-hidden', s > lastScrollY && s > 80);
            if (s <= lastScrollY) navbar.classList.remove('nav-hidden');
            navbar.classList.toggle('scrolled', (heroHeight - s) <= 80);
            lastScrollY = s; navTicking = false;
        }
        window.addEventListener('scroll', () => { if (!navTicking) { navTicking = true; requestAnimationFrame(updateNav); } }, { passive: true });
        updateNav();

        // Drawer
        const hamburger = document.getElementById('hamburger');
        const drawer = document.getElementById('drawer');
        const drawerOverlay = document.getElementById('drawerOverlay');
        const drawerClose = document.getElementById('drawerClose');
        const openDrawer = () => { drawer.classList.add('open'); drawerOverlay.classList.add('open'); hamburger.classList.add('open'); hamburger.setAttribute('aria-expanded', 'true'); document.body.style.overflow = 'hidden'; };
        const closeDrawer = () => { drawer.classList.remove('open'); drawerOverlay.classList.remove('open'); hamburger.classList.remove('open'); hamburger.setAttribute('aria-expanded', 'false'); document.body.style.overflow = ''; };
        hamburger.addEventListener('click', () => drawer.classList.contains('open') ? closeDrawer() : openDrawer());
        drawerClose.addEventListener('click', closeDrawer);
        drawerOverlay.addEventListener('click', closeDrawer);
        document.addEventListener('keydown', e => { if (e.key === 'Escape') closeDrawer(); });
        document.querySelectorAll('.drawer-nav a').forEach(l => l.addEventListener('click', closeDrawer));

        // Scroll animations
        const animEls = document.querySelectorAll('.anim-left, .anim-right, .anim-up');
        const animObs = new IntersectionObserver(entries => {
            entries.forEach(e => e.target.classList.toggle('in-view', e.isIntersecting));
        }, { threshold: 0, rootMargin: '0px 0px -60px 0px' });
        animEls.forEach(el => animObs.observe(el));

        // Process cards stagger
        const cards = document.querySelectorAll('.process-card');
        const cardObs = new IntersectionObserver(entries => {
            entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('in-view'); cardObs.unobserve(e.target); } });
        }, { threshold: 0, rootMargin: '0px 0px -40px 0px' });
        cards.forEach((c, i) => { c.style.transitionDelay = (i * 0.08) + 's'; c.style.transition = 'opacity 0.6s cubic-bezier(.34,1.56,.64,1), transform 0.6s cubic-bezier(.34,1.56,.64,1), box-shadow 0.3s, border-color 0.3s'; cardObs.observe(c); });

        // Footer animations
        const fxObs = new IntersectionObserver(entries => { entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('fx-in'); fxObs.unobserve(e.target); } }); }, { threshold: 0, rootMargin: '0px 0px -30px 0px' });
        document.querySelectorAll('.fx-top-item').forEach((el, i) => { el.style.transitionDelay = (i * 0.08) + 's'; fxObs.observe(el); });
        document.querySelectorAll('.fx-logo-item').forEach((el, i) => { el.style.transitionDelay = (i * 0.1) + 's'; fxObs.observe(el); });
        const fx2Obs = new IntersectionObserver(entries => { entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('fx-in'); fx2Obs.unobserve(e.target); } }); }, { threshold: 0, rootMargin: '0px 0px -30px 0px' });
        document.querySelectorAll('.fx2-col').forEach((el, i) => { el.style.transitionDelay = (i * 0.1) + 's'; fx2Obs.observe(el); });
