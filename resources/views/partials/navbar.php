<?php
/**
 * Partial: Navbar
 * Coffee Export B2B | AromaSource Global
 *
 * Variables: $activeNav, $appConfig
 */
$baseUrl = rtrim($appConfig['url'] ?? '', '/');
$nav = $activeNav ?? 'home';
?>
<header class="navbar" id="navbar" role="banner">
  <div class="container">
    <div class="navbar__inner">

      <!-- Logo -->
      <a href="/" class="navbar__logo" aria-label="<?= htmlspecialchars($appConfig['name']) ?> — Home">
        <div class="navbar__logo-mark" aria-hidden="true">☕</div>
        <div class="navbar__logo-text">
          <?= htmlspecialchars($appConfig['name']) ?>
          <span class="navbar__logo-sub">Coffee Export</span>
        </div>
      </a>

      <!-- Desktop Navigation -->
      <nav class="navbar__nav" role="navigation" aria-label="Main navigation">
        <a href="/"           class="navbar__link <?= $nav === 'home'       ? 'active' : '' ?>">Home</a>
        <a href="/catalog"    class="navbar__link <?= $nav === 'catalog'    ? 'active' : '' ?>">Products</a>
        <a href="/#warehousing" class="navbar__link <?= $nav === 'warehouse' ? 'active' : '' ?>">Warehousing</a>
        <a href="/#testimonials" class="navbar__link">Client Reviews</a>
        <a href="/#about"     class="navbar__link <?= $nav === 'about'      ? 'active' : '' ?>">About</a>
      </nav>

      <!-- CTA + Hamburger -->
      <div class="navbar__actions">
        <a href="/inquiry" class="btn btn-primary btn-sm <?= $nav === 'inquiry' ? 'active' : '' ?>"
           aria-label="Request a wholesale quote">
          📋 Request Quote
        </a>
        <button class="navbar__hamburger" aria-label="Open mobile menu" aria-expanded="false" aria-controls="mobile-menu">
          <span></span>
          <span></span>
          <span></span>
        </button>
      </div>

    </div>
  </div>
</header>
