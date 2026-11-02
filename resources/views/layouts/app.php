<?php
/**
 * Master Layout — app.php
 * Coffee Export B2B | AromaSource Global
 *
 * Variables available:
 *   $content      — rendered view HTML
 *   $pageTitle    — <title> tag
 *   $metaDescription — meta description
 *   $appConfig    — config/app.php array
 *   $activeNav    — currently active nav item key
 */

$pageTitle       ??= $appConfig['name'] . ' — Premium Coffee Export';
$metaDescription ??= 'B2B wholesale coffee export specialists. Premium Indonesian and Ethiopian green beans and roasted coffee. ISO 22000 certified. Request your wholesale quote.';
$activeNav       ??= 'home';
$baseUrl = rtrim($appConfig['url'] ?? '', '/');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="<?= htmlspecialchars($metaDescription, ENT_QUOTES, 'UTF-8') ?>">
  <meta name="robots" content="index, follow">

  <!-- Open Graph -->
  <meta property="og:title"       content="<?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?>">
  <meta property="og:description" content="<?= htmlspecialchars($metaDescription, ENT_QUOTES, 'UTF-8') ?>">
  <meta property="og:type"        content="website">
  <meta property="og:site_name"   content="<?= htmlspecialchars($appConfig['name'], ENT_QUOTES, 'UTF-8') ?>">

  <title><?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?></title>

  <!-- Preconnect for performance -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

  <!-- CSS -->
  <link rel="stylesheet" href="<?= $baseUrl ?>/css/app.css">
  <link rel="stylesheet" href="<?= $baseUrl ?>/css/hero.css">
  <link rel="stylesheet" href="<?= $baseUrl ?>/css/catalog.css">
  <link rel="stylesheet" href="<?= $baseUrl ?>/css/warehouse.css">
  <link rel="stylesheet" href="<?= $baseUrl ?>/css/testimonials.css">

  <!-- Favicon (inline SVG) -->
  <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>☕</text></svg>">
</head>
<body>

  <!-- Navigation -->
  <?php include ROOT_PATH . '/resources/views/partials/navbar.php'; ?>

  <!-- Mobile Menu -->
  <nav class="mobile-menu" role="dialog" aria-modal="true" aria-label="Mobile navigation">
    <button class="mobile-menu__close" aria-label="Close menu">✕</button>
    <a href="/" class="mobile-menu__link <?= $activeNav === 'home'       ? 'active' : '' ?>">Home</a>
    <a href="/catalog" class="mobile-menu__link <?= $activeNav === 'catalog'    ? 'active' : '' ?>">Product Catalog</a>
    <a href="/#warehousing" class="mobile-menu__link">Warehousing</a>
    <a href="/#testimonials" class="mobile-menu__link">Client Reviews</a>
    <a href="/#about" class="mobile-menu__link">About Us</a>
    <a href="/inquiry" class="mobile-menu__link btn btn-primary" style="margin-top:1rem;">Request Quote</a>
  </nav>

  <!-- Main Content -->
  <main id="main-content">
    <?= $content ?>
  </main>

  <!-- Footer -->
  <?php include ROOT_PATH . '/resources/views/partials/footer.php'; ?>

  <!-- JavaScript -->
  <script src="<?= $baseUrl ?>/js/app.js" defer></script>
  <script src="<?= $baseUrl ?>/js/catalog.js" defer></script>
  <script src="<?= $baseUrl ?>/js/carousel.js" defer></script>

</body>
</html>
