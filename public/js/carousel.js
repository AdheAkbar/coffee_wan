/**
 * carousel.js — Testimonial Carousel
 * Coffee Export B2B | AromaSource Global
 *
 * Auto-playing carousel with:
 *   - Touch/swipe support
 *   - Keyboard navigation
 *   - Dot indicators
 *   - Progress bar auto-advance (5s per slide)
 *   - Pause on hover / focus
 *   - Responsive: 3-up → 2-up → 1-up
 */

'use strict';

(function CarouselModule() {

  const SLIDE_DURATION = 5000; // ms per slide
  const SLIDES_PER_VIEW_DESKTOP = 3;
  const SLIDES_PER_VIEW_TABLET  = 2;
  const SLIDES_PER_VIEW_MOBILE  = 1;

  /* ── Per-Carousel initialiser ──────────────────────────────── */
  function initCarousel(wrapper) {
    const track       = wrapper.querySelector('.carousel__track');
    const slides      = [...wrapper.querySelectorAll('.carousel__slide')];
    const prevBtn     = wrapper.querySelector('.carousel__btn--prev');
    const nextBtn     = wrapper.querySelector('.carousel__btn--next');
    const dotsWrapper = wrapper.querySelector('.carousel__dots');
    const progressBar = wrapper.querySelector('.carousel__progress-fill');

    if (!track || !slides.length) return;

    let currentIndex = 0;
    let autoTimer    = null;
    let progressTimer = null;
    let isPaused     = false;
    let touchStartX  = 0;
    let touchEndX    = 0;

    /* ── Responsive slides-per-view ─────────────────────────── */
    const getSlidesPerView = () => {
      if (window.innerWidth <= 640)  return SLIDES_PER_VIEW_MOBILE;
      if (window.innerWidth <= 1024) return SLIDES_PER_VIEW_TABLET;
      return SLIDES_PER_VIEW_DESKTOP;
    };

    const getTotalPages = () => Math.ceil(slides.length / getSlidesPerView());

    /* ── Render ──────────────────────────────────────────────── */
    const goTo = (index) => {
      const total = getTotalPages();
      currentIndex = ((index % total) + total) % total; // wrap

      const perView   = getSlidesPerView();
      const offset    = (currentIndex * perView / slides.length) * 100;
      track.style.transform = `translateX(-${offset}%)`;

      // Update dots
      if (dotsWrapper) {
        dotsWrapper.querySelectorAll('.carousel__dot').forEach((dot, i) => {
          dot.classList.toggle('active', i === currentIndex);
        });
      }

      // Update prev/next button state
      if (prevBtn) prevBtn.disabled = false;
      if (nextBtn) nextBtn.disabled = false;

      // Reset progress
      resetProgress();
    };

    /* ── Auto-advance ────────────────────────────────────────── */
    const startAuto = () => {
      if (autoTimer) clearInterval(autoTimer);
      autoTimer = setInterval(() => {
        if (!isPaused) goTo(currentIndex + 1);
      }, SLIDE_DURATION);
    };

    const stopAuto = () => {
      if (autoTimer) clearInterval(autoTimer);
      autoTimer = null;
    };

    /* ── Progress Bar ────────────────────────────────────────── */
    const resetProgress = () => {
      if (!progressBar) return;
      progressBar.style.transition = 'none';
      progressBar.style.width      = '0%';

      // Force reflow
      void progressBar.offsetWidth;

      progressBar.style.transition = `width ${SLIDE_DURATION}ms linear`;
      progressBar.style.width      = '100%';
    };

    /* ── Build dots ──────────────────────────────────────────── */
    const buildDots = () => {
      if (!dotsWrapper) return;
      dotsWrapper.innerHTML = '';
      const total = getTotalPages();

      for (let i = 0; i < total; i++) {
        const dot = document.createElement('button');
        dot.className = 'carousel__dot' + (i === 0 ? ' active' : '');
        dot.setAttribute('aria-label', `Go to slide ${i + 1}`);
        dot.addEventListener('click', () => goTo(i));
        dotsWrapper.appendChild(dot);
      }
    };

    /* ── Controls ────────────────────────────────────────────── */
    if (prevBtn) prevBtn.addEventListener('click', () => goTo(currentIndex - 1));
    if (nextBtn) nextBtn.addEventListener('click', () => goTo(currentIndex + 1));

    /* ── Keyboard ────────────────────────────────────────────── */
    wrapper.setAttribute('tabindex', '0');
    wrapper.addEventListener('keydown', (e) => {
      if (e.key === 'ArrowLeft')  { goTo(currentIndex - 1); e.preventDefault(); }
      if (e.key === 'ArrowRight') { goTo(currentIndex + 1); e.preventDefault(); }
    });

    /* ── Hover pause ─────────────────────────────────────────── */
    wrapper.addEventListener('mouseenter', () => { isPaused = true; });
    wrapper.addEventListener('mouseleave', () => { isPaused = false; });
    wrapper.addEventListener('focusin',    () => { isPaused = true; });
    wrapper.addEventListener('focusout',   () => { isPaused = false; });

    /* ── Touch / Swipe ───────────────────────────────────────── */
    track.addEventListener('touchstart', (e) => {
      touchStartX = e.changedTouches[0].clientX;
    }, { passive: true });

    track.addEventListener('touchend', (e) => {
      touchEndX = e.changedTouches[0].clientX;
      const diff = touchStartX - touchEndX;

      if (Math.abs(diff) > 40) {
        goTo(diff > 0 ? currentIndex + 1 : currentIndex - 1);
      }
    }, { passive: true });

    /* ── Resize handler ──────────────────────────────────────── */
    let resizeTimer;
    window.addEventListener('resize', () => {
      clearTimeout(resizeTimer);
      resizeTimer = setTimeout(() => {
        buildDots();
        goTo(0);
      }, 250);
    });

    /* ── Visibility API — pause when tab hidden ──────────────── */
    document.addEventListener('visibilitychange', () => {
      if (document.hidden) {
        isPaused = true;
        stopAuto();
      } else {
        isPaused = false;
        startAuto();
      }
    });

    /* ── Boot ────────────────────────────────────────────────── */
    buildDots();
    goTo(0);
    startAuto();
  }

  /* ── Init all carousels on page ─────────────────────────────── */
  document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.carousel').forEach(initCarousel);
  });

  /* ── Dynamic Testimonial Loader ─────────────────────────────── */
  // If the testimonials container has data-api="true", load from JSON API
  (function loadTestimonialsFromAPI() {
    const container = document.querySelector('[data-testimonials-api]');
    if (!container) return;

    const apiUrl = container.dataset.testimonialsApi;

    fetch(apiUrl)
      .then(r => r.json())
      .then(({ success, data }) => {
        if (!success || !data?.length) return;

        const track = container.querySelector('.carousel__track');
        if (!track) return;

        // Clear skeleton placeholders
        track.innerHTML = '';

        // Group into pages of 3
        const perPage = 3;
        for (let i = 0; i < data.length; i += perPage) {
          const group = data.slice(i, i + perPage);
          const slide = document.createElement('div');
          slide.className = 'carousel__slide';

          const inner = document.createElement('div');
          inner.className = 'carousel__slide-inner';

          group.forEach(t => {
            inner.appendChild(buildCard(t));
          });

          slide.appendChild(inner);
          track.appendChild(slide);
        }

        // Re-init carousel after injection
        initCarousel(container);
      })
      .catch(err => console.warn('Testimonials API error:', err));

    function buildCard(t) {
      const ratingVal = parseInt(t.rating, 10) || 5;
      const stars     = '★'.repeat(ratingVal) + '☆'.repeat(5 - ratingVal);

      const card = document.createElement('div');
      card.className = 'testimonial-card';
      card.innerHTML = `
        <div class="stars" aria-label="Rating: ${ratingVal} out of 5">
          ${[...stars].map((s, i) => `<span class="star ${i < ratingVal ? 'filled' : 'empty'}">${s}</span>`).join('')}
        </div>
        <p class="testimonial-card__quote">${t.quote}</p>
        ${t.volume_per_year ? `<div class="testimonial-card__volume">📦 ${t.volume_per_year}</div>` : ''}
        <div class="testimonial-card__client">
          <div class="testimonial-card__logo">
            <div class="company-initials">${t.initials ?? '??'}</div>
          </div>
          <div class="testimonial-card__client-info">
            <div class="testimonial-card__name">${t.client_name}</div>
            <div class="testimonial-card__title">${t.client_title ?? ''}</div>
            <div class="testimonial-card__company">${t.company_name}</div>
            <div class="testimonial-card__country">${t.company_country ?? ''}</div>
          </div>
          ${t.partnership_since ? `
          <div class="testimonial-card__since">
            <div class="testimonial-card__since-label">Partner since</div>
            <div class="testimonial-card__since-year">${t.partnership_since}</div>
          </div>` : ''}
        </div>`;
      return card;
    }
  })();

})();
