/**
 * app.js — Global Application JavaScript
 * Coffee Export B2B | AromaSource Global
 *
 * Handles: sticky navbar, mobile menu, scroll animations, smooth scrolling
 */

'use strict';

/* ── Utility ─────────────────────────────────────────────────── */
const $ = (sel, ctx = document) => ctx.querySelector(sel);
const $$ = (sel, ctx = document) => [...ctx.querySelectorAll(sel)];

/* ── Navbar: Scroll Behavior ─────────────────────────────────── */
(function initNavbar() {
  const navbar = $('.navbar');
  if (!navbar) return;

  let lastScroll = 0;

  const updateNavbar = () => {
    const scrollY = window.scrollY;

    // Add/remove scrolled class
    if (scrollY > 60) {
      navbar.classList.add('scrolled');
    } else {
      navbar.classList.remove('scrolled');
    }

    // Hide on scroll down, show on scroll up
    if (scrollY > lastScroll && scrollY > 200) {
      navbar.style.transform = 'translateY(-100%)';
    } else {
      navbar.style.transform = 'translateY(0)';
    }

    lastScroll = scrollY;
  };

  window.addEventListener('scroll', updateNavbar, { passive: true });
  updateNavbar();
})();

/* ── Mobile Menu ─────────────────────────────────────────────── */
(function initMobileMenu() {
  const hamburger = $('.navbar__hamburger');
  const mobileMenu = $('.mobile-menu');
  const closeBtn = $('.mobile-menu__close');

  if (!hamburger || !mobileMenu) return;

  const openMenu = () => {
    mobileMenu.classList.add('open');
    document.body.style.overflow = 'hidden';
    hamburger.setAttribute('aria-expanded', 'true');
  };

  const closeMenu = () => {
    mobileMenu.classList.remove('open');
    document.body.style.overflow = '';
    hamburger.setAttribute('aria-expanded', 'false');
  };

  hamburger.addEventListener('click', openMenu);
  if (closeBtn) closeBtn.addEventListener('click', closeMenu);

  // Close on link click
  $$('.mobile-menu__link', mobileMenu).forEach(link => {
    link.addEventListener('click', closeMenu);
  });

  // Close on backdrop click
  mobileMenu.addEventListener('click', (e) => {
    if (e.target === mobileMenu) closeMenu();
  });

  // Close on Escape
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closeMenu();
  });
})();

/* ── Smooth Scroll for Anchor Links ─────────────────────────── */
(function initSmoothScroll() {
  document.addEventListener('click', (e) => {
    const link = e.target.closest('a[href^="#"]');
    if (!link) return;

    const target = document.getElementById(link.getAttribute('href').slice(1));
    if (!target) return;

    e.preventDefault();
    const navHeight = $('.navbar')?.offsetHeight ?? 80;
    const top = target.getBoundingClientRect().top + window.scrollY - navHeight - 16;

    window.scrollTo({ top, behavior: 'smooth' });
  });
})();

/* ── Scroll-Reveal Animations (Intersection Observer) ────────── */
(function initScrollReveal() {
  const elements = $$('.fade-in');
  if (!elements.length || !('IntersectionObserver' in window)) {
    // Fallback: make all visible
    elements.forEach(el => el.classList.add('visible'));
    return;
  }

  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
          observer.unobserve(entry.target);
        }
      });
    },
    { threshold: 0.12, rootMargin: '0px 0px -40px 0px' }
  );

  elements.forEach((el, i) => {
    // Stagger delay for grid children
    if (el.dataset.delay) {
      el.style.transitionDelay = el.dataset.delay;
    } else {
      const siblings = el.parentElement?.querySelectorAll('.fade-in') ?? [];
      const idx = [...siblings].indexOf(el);
      if (idx > 0) el.style.transitionDelay = `${idx * 80}ms`;
    }
    observer.observe(el);
  });
})();

/* ── Stats Counter Animation ─────────────────────────────────── */
(function initCounters() {
  const counters = $$('[data-counter]');
  if (!counters.length) return;

  const easeOut = (t) => 1 - Math.pow(1 - t, 3);

  const animateCounter = (el) => {
    const target = parseFloat(el.dataset.counter);
    const suffix = el.dataset.counterSuffix ?? '';
    const prefix = el.dataset.counterPrefix ?? '';
    const duration = 1800;
    const start = performance.now();

    const tick = (now) => {
      const progress = Math.min((now - start) / duration, 1);
      const value = easeOut(progress) * target;
      el.textContent = prefix + (Number.isInteger(target) ? Math.floor(value) : value.toFixed(1)) + suffix;
      if (progress < 1) requestAnimationFrame(tick);
    };

    requestAnimationFrame(tick);
  };

  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          animateCounter(entry.target);
          observer.unobserve(entry.target);
        }
      });
    },
    { threshold: 0.5 }
  );

  counters.forEach(el => observer.observe(el));
})();

/* ── Warehouse card expand (click for full description) ──────── */
(function initWarehouseCards() {
  $$('.warehouse-card').forEach(card => {
    card.addEventListener('click', () => {
      card.classList.toggle('expanded');
    });
  });
})();

/* ── Active nav link highlight ───────────────────────────────── */
(function initActiveNav() {
  const path = window.location.pathname.replace(/\/$/, '') || '/';
  $$('.navbar__link').forEach(link => {
    const href = link.getAttribute('href').replace(/\/$/, '') || '/';
    if (href === path || (href !== '/' && path.startsWith(href))) {
      link.classList.add('active');
    }
  });
})();

/* ── Expose simple global helpers ────────────────────────────── */
window.AromaApp = { $, $$ };
