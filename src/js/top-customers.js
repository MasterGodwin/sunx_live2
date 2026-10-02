// ══════════════════════════════════════
// TOP CUSTOMERS — Logo Carousel
// ══════════════════════════════════════
(function () {
  const track = document.getElementById('tcTrack');
  if (!track) return;

  // Duplicate the logo set once so the CSS scroll-loop (translateX -50%)
  // always has a seamless second copy to hand off to, regardless of
  // how many logos are added/removed in the HTML.
  const original = Array.from(track.children);
  original.forEach(node => {
    track.appendChild(node.cloneNode(true));
  });

  // Pause animation on touch (mobile) so users can tap logos without
  // the strip sliding away mid-interaction.
  let pauseTimeout;
  track.addEventListener('touchstart', () => {
    track.style.animationPlayState = 'paused';
  }, { passive: true });

  track.addEventListener('touchend', () => {
    clearTimeout(pauseTimeout);
    pauseTimeout = setTimeout(() => {
      track.style.animationPlayState = 'running';
    }, 1500);
  }, { passive: true });
})();
