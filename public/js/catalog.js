/**
 * catalog.js — Product Catalog Tab Switching & Dynamic Loading
 * Coffee Export B2B | AromaSource Global
 *
 * Handles tab switching between Green Beans and Roasted Beans panels.
 * Optionally fetches fresh data from /api/products for SPA-style updates.
 */

'use strict';

(function CatalogModule() {

  /* ── State ────────────────────────────────────────────────── */
  let activeTab = 'green';
  let isLoading = false;

  /* ── DOM Refs ─────────────────────────────────────────────── */
  const tabsContainer = document.querySelector('.catalog__tabs');
  const panels = {
    green:   document.querySelector('#panel-green'),
    roasted: document.querySelector('#panel-roasted'),
  };

  if (!tabsContainer) return; // Not on catalog page

  /* ── Tab Switching ────────────────────────────────────────── */
  tabsContainer.addEventListener('click', (e) => {
    const btn = e.target.closest('.catalog__tab[data-tab]');
    if (!btn || isLoading) return;

    const tab = btn.dataset.tab;
    if (tab === activeTab) return;

    switchTab(tab);
  });

  function switchTab(tab) {
    activeTab = tab;

    // Update button states
    tabsContainer.querySelectorAll('.catalog__tab').forEach(btn => {
      btn.classList.toggle('active', btn.dataset.tab === tab);
      btn.setAttribute('aria-selected', btn.dataset.tab === tab);
    });

    // Update panel visibility
    Object.entries(panels).forEach(([key, panel]) => {
      if (!panel) return;
      panel.classList.toggle('active', key === tab);
    });

    // Update URL without reload (for bookmarking)
    const url = new URL(window.location);
    url.searchParams.set('tab', tab);
    window.history.replaceState({}, '', url);

    // Animate cards on tab switch
    animatePanelCards(panels[tab]);
  }

  /* ── Card entrance animation ──────────────────────────────── */
  function animatePanelCards(panel) {
    if (!panel) return;

    const cards = panel.querySelectorAll('.product-card');
    cards.forEach((card, i) => {
      card.style.opacity    = '0';
      card.style.transform  = 'translateY(16px)';

      setTimeout(() => {
        card.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
        card.style.opacity    = '1';
        card.style.transform  = 'translateY(0)';
      }, i * 60);
    });
  }

  /* ── Score bar animation ──────────────────────────────────── */
  function animateScoreBars(container) {
    if (!container) return;

    const bars = container.querySelectorAll('.score-fill[data-score]');
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          const bar = entry.target;
          const score = parseFloat(bar.dataset.score);
          const pct = ((score - 60) / 40) * 100; // 60-100 range → 0-100%
          bar.style.width = Math.max(0, Math.min(100, pct)) + '%';
          observer.unobserve(bar);
        }
      });
    }, { threshold: 0.3 });

    bars.forEach(bar => {
      bar.style.width = '0%';
      observer.observe(bar);
    });
  }

  /* ── Spec row hover tooltip ───────────────────────────────── */
  function initSpecTooltips(container) {
    if (!container) return;

    const tooltips = {
      'Moisture': 'Green bean moisture percentage. Industry standard: 10–13%',
      'Screen': 'Bean size screen. Higher = larger bean.',
      'Grade': 'Export grading standard. Grade 1 = highest quality.',
      'MOQ': 'Minimum Order Quantity for this product.',
    };

    container.querySelectorAll('.spec-label').forEach(label => {
      const text = label.textContent.trim();
      const tip = Object.entries(tooltips).find(([k]) => text.includes(k));
      if (!tip) return;

      label.title = tip[1];
      label.style.cursor = 'help';
      label.style.borderBottom = '1px dashed var(--border)';
    });
  }

  /* ── Product Card: Request Quote quick link ───────────────── */
  function initQuickInquiry(container) {
    if (!container) return;

    container.querySelectorAll('.btn-quote-quick').forEach(btn => {
      btn.addEventListener('click', (e) => {
        e.preventDefault();
        const productName = btn.dataset.product ?? '';
        const inquiryUrl  = `/inquiry?product=${encodeURIComponent(productName)}&tab=direct`;
        window.location.href = inquiryUrl;
      });
    });
  }

  /* ── Filter by origin (search input on catalog page) ─────── */
  const searchInput = document.querySelector('#catalog-search');
  if (searchInput) {
    let debounceTimer;

    searchInput.addEventListener('input', () => {
      clearTimeout(debounceTimer);
      debounceTimer = setTimeout(() => filterCards(searchInput.value.trim()), 250);
    });

    function filterCards(query) {
      const lq = query.toLowerCase();
      const panel = panels[activeTab];
      if (!panel) return;

      const cards = panel.querySelectorAll('.product-card');
      let visible = 0;

      cards.forEach(card => {
        const text = card.textContent.toLowerCase();
        const match = !lq || text.includes(lq);
        card.style.display = match ? '' : 'none';
        if (match) visible++;
      });

      // Show empty state if no results
      const empty = panel.querySelector('.catalog-empty');
      if (empty) empty.style.display = visible === 0 ? 'block' : 'none';
    }
  }

  /* ── Init on DOM Ready ────────────────────────────────────── */
  function init() {
    // Read tab from URL
    const urlTab = new URLSearchParams(window.location.search).get('tab');
    if (urlTab && panels[urlTab]) {
      switchTab(urlTab);
    } else {
      // Default: activate green
      panels.green?.classList.add('active');
      tabsContainer.querySelector('[data-tab="green"]')?.classList.add('active');
    }

    // Animate score bars for all panels
    Object.values(panels).forEach(p => animateScoreBars(p));

    // Init tooltips & quick inquiry
    Object.values(panels).forEach(p => {
      initSpecTooltips(p);
      initQuickInquiry(p);
    });

    // Initial card animation
    animatePanelCards(panels[activeTab]);
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }

})();
