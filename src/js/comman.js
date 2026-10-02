// ══════════════════════════════════════
// NAVBAR
// ══════════════════════════════════════
const navbar = document.getElementById('navbar');
const hero = document.getElementById('hero');
let lastScrollY = window.scrollY;
let navTicking = false;
let heroHeight = hero.offsetHeight;

window.addEventListener('resize', () => { heroHeight = hero.offsetHeight; }, { passive: true });

function updateNav() {
  const currentScrollY = window.scrollY;
  const heroBottom = heroHeight - currentScrollY;
  navbar.classList.toggle('nav-hidden', currentScrollY > lastScrollY && currentScrollY > 80);
  if (currentScrollY <= lastScrollY) navbar.classList.remove('nav-hidden');
  navbar.classList.toggle('scrolled', heroBottom <= 80);
  lastScrollY = currentScrollY;
  navTicking = false;
}

window.addEventListener('scroll', () => {
  if (!navTicking) {
    navTicking = true;
    requestAnimationFrame(updateNav);
  }
}, { passive: true });
updateNav();

// ══════════════════════════════════════
// DRAWER
// ══════════════════════════════════════
const hamburger = document.getElementById('hamburger');
const drawer = document.getElementById('drawer');
const drawerOverlay = document.getElementById('drawerOverlay');
const drawerClose = document.getElementById('drawerClose');

const openDrawer = () => {
  drawer.classList.add('open');
  drawerOverlay.classList.add('open');
  hamburger.classList.add('open');
  hamburger.setAttribute('aria-expanded', 'true');
  document.body.style.overflow = 'hidden';
};

const closeDrawer = () => {
  drawer.classList.remove('open');
  drawerOverlay.classList.remove('open');
  hamburger.classList.remove('open');
  hamburger.setAttribute('aria-expanded', 'false');
  document.body.style.overflow = '';
};

hamburger.addEventListener('click', () =>
  drawer.classList.contains('open') ? closeDrawer() : openDrawer()
);
drawerClose.addEventListener('click', closeDrawer);
drawerOverlay.addEventListener('click', closeDrawer);
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeDrawer(); });
document.querySelectorAll('.drawer-nav a').forEach(l => l.addEventListener('click', closeDrawer));

// (function () {
//   const preloader = document.getElementById('preloader');
//   const root = document.documentElement;
//   const MIN_VISIBLE_MS = 400;
//   const MAX_WAIT_MS = 4000;
//   const shownAt = Date.now();
//   let hidden = false;

//   function hidePreloader() {
//     if (hidden) return;
//     hidden = true; 
//     const elapsed = Date.now() - shownAt;
//     const wait = Math.max(0, MIN_VISIBLE_MS - elapsed);
//     setTimeout(() => {
//       root.classList.remove('preload');
//       if (preloader) {
//         preloader.classList.add('preloader-hide');
//         preloader.addEventListener('transitionend', () => preloader.remove(), { once: true });
//       }
//     }, wait);
//   }

//   if (document.fonts && document.fonts.ready) {
//     document.fonts.ready.then(hidePreloader).catch(hidePreloader);
//   }
//   window.addEventListener('load', hidePreloader);
//   setTimeout(hidePreloader, MAX_WAIT_MS);
// })();

// document.documentElement.classList.add('preload');

document.addEventListener('DOMContentLoaded', function () {
  var items = document.querySelectorAll('.mv-acc-item');

  items.forEach(function (item) {
    item.querySelector('.mv-acc-header').addEventListener('click', function () {
      var isOpen = item.classList.contains('mv-acc-open');
      var header = item.querySelector('.mv-acc-header');
      var toggle = item.querySelector('.mv-acc-toggle');

      if (isOpen) {
        item.classList.remove('mv-acc-open');
        toggle.textContent = '+';
        header.setAttribute('aria-expanded', 'false');
      } else {
        item.classList.add('mv-acc-open');
        toggle.textContent = '−';
        header.setAttribute('aria-expanded', 'true');
      }
    });
  });

  // ── Quick Links Footer Accordion (unchanged) ──
  document.querySelectorAll('.ql-acc-btn').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var li = this.closest('.ql-acc-item');
      var sub = li.querySelector('.ql-acc-sub');
      var icon = li.querySelector('.ql-acc-icon');
      var isOpen = li.classList.contains('ql-open');

      li.closest('.fx2-quicklinks').querySelectorAll('.ql-acc-item').forEach(function (el) {
        el.classList.remove('ql-open');
        el.querySelector('.ql-acc-sub').style.maxHeight = '0';
        el.querySelector('.ql-acc-icon').textContent = '+';
        el.querySelector('.ql-acc-btn').setAttribute('aria-expanded', 'false');
      });

      if (!isOpen) {
        li.classList.add('ql-open');
        sub.style.maxHeight = sub.scrollHeight + 'px';
        icon.textContent = '−';
        btn.setAttribute('aria-expanded', 'true');
      }
    });
  });
});