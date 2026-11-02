<?php
/**
 * Page: Product Catalog
 * Coffee Export B2B | AromaSource Global
 *
 * Variables: $greenBeans, $roastedBeans, $counts, $activeTab,
 *            $product (optional, for detail view), $error, $appConfig
 */

$baseUrl = rtrim($appConfig['url'] ?? '', '/');
$view    = $view ?? 'list';
?>

<?php if (isset($error) && $error): ?>
<!-- ── 404 Product Error ──────────────────────────────────── -->
<div style="padding:10rem 2rem;text-align:center;min-height:60vh;display:flex;align-items:center;justify-content:center;flex-direction:column;gap:1.5rem">
  <div style="font-size:4rem">📦</div>
  <h1 style="font-size:1.75rem;color:var(--espresso)">Product Not Found</h1>
  <p style="color:var(--text-muted)"><?= htmlspecialchars($error) ?></p>
  <a href="/catalog" class="btn btn-primary">← Back to Catalog</a>
</div>

<?php elseif ($view === 'detail' && isset($product)): ?>
<!-- ── Product Detail Page ────────────────────────────────── -->
<div class="product-detail">
  <div class="container">

    <!-- Breadcrumb -->
    <nav aria-label="Breadcrumb" style="margin-bottom:2rem;font-size:0.875rem;color:var(--text-muted)">
      <a href="/" style="color:var(--forest)">Home</a> /
      <a href="/catalog" style="color:var(--forest)">Catalog</a> /
      <a href="/catalog?tab=<?= htmlspecialchars($product['category']) ?>"
         style="color:var(--forest)"><?= ucfirst($product['category']) ?> Beans</a> /
      <span><?= htmlspecialchars($product['name']) ?></span>
    </nav>

    <div class="product-detail__grid">

      <!-- Visual -->
      <div class="product-detail__visual product-card--<?= htmlspecialchars($product['category']) ?> product-card__visual">
        <div class="product-card__visual-icon" style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);font-size:5rem;opacity:0.5">
          <?= $product['category'] === 'green' ? '🌿' : '☕' ?>
        </div>
        <div class="product-card__origin-tag">
          📍 <?= htmlspecialchars($product['origin']) ?>
        </div>
        <?php if (!empty($product['badge'])): ?>
        <div style="position:absolute;top:1rem;right:1rem">
          <span class="badge badge-gold"><?= htmlspecialchars($product['badge']) ?></span>
        </div>
        <?php endif; ?>
      </div>

      <!-- Details -->
      <div>
        <span class="section-eyebrow">
          <?= $product['category'] === 'green' ? '🌿 Green Bean' : '☕ Roasted Bean' ?>
        </span>
        <h1 style="font-size:2rem;font-weight:800;color:var(--espresso);margin:0.5rem 0 1rem">
          <?= htmlspecialchars($product['name']) ?>
        </h1>

        <?php if (!empty($product['description'])): ?>
        <p style="color:var(--text-muted);line-height:1.75;margin-bottom:2rem">
          <?= htmlspecialchars($product['description']) ?>
        </p>
        <?php endif; ?>

        <!-- Technical Specs Table -->
        <h2 style="font-size:1rem;font-weight:700;color:var(--espresso);margin-bottom:1rem">
          Technical Specifications
        </h2>
        <table class="product-detail__specs-table" style="margin-bottom:2rem">
          <tbody>
            <tr><th>Origin</th><td><?= htmlspecialchars($product['origin']) ?></td></tr>
            <?php if (!empty($product['region'])): ?>
            <tr><th>Region</th><td><?= htmlspecialchars($product['region']) ?></td></tr>
            <?php endif; ?>
            <?php if (!empty($product['altitude_masl'])): ?>
            <tr><th>Altitude</th><td><?= htmlspecialchars($product['altitude_masl']) ?> masl</td></tr>
            <?php endif; ?>
            <tr><th>Process</th><td><?= htmlspecialchars(ucfirst($product['process'] ?? '')) ?></td></tr>
            <?php if (!empty($product['grade'])): ?>
            <tr><th>Grade</th><td><?= htmlspecialchars($product['grade']) ?></td></tr>
            <?php endif; ?>
            <?php if (!empty($product['screen_size'])): ?>
            <tr><th>Screen Size</th><td><?= htmlspecialchars($product['screen_size']) ?></td></tr>
            <?php endif; ?>
            <?php if (!empty($product['moisture_pct'])): ?>
            <tr><th>Moisture %</th><td><?= htmlspecialchars($product['moisture_pct']) ?>%</td></tr>
            <?php endif; ?>
            <?php if (!empty($product['roast_level'])): ?>
            <tr><th>Roast Level</th><td><?= htmlspecialchars(ucwords($product['roast_level'])) ?></td></tr>
            <?php endif; ?>
            <?php if (!empty($product['cupping_score'])): ?>
            <tr><th>Cupping Score</th><td><?= htmlspecialchars($product['cupping_score']) ?> / 100</td></tr>
            <?php endif; ?>
            <?php if (!empty($product['flavor_notes'])): ?>
            <tr><th>Flavor Notes</th><td><?= htmlspecialchars($product['flavor_notes']) ?></td></tr>
            <?php endif; ?>
            <tr><th>Price</th><td style="color:var(--espresso);font-weight:800">$<?= number_format((float)$product['price_per_kg'], 2) ?>/kg FOB</td></tr>
            <tr><th>MOQ</th><td><?= number_format((int)$product['moq_kg']) ?> kg</td></tr>
            <tr><th>Lead Time</th><td><?= htmlspecialchars($product['lead_days'] ?? 14) ?> business days</td></tr>
          </tbody>
        </table>

        <div style="display:flex;gap:1rem;flex-wrap:wrap">
          <a href="/inquiry?product=<?= urlencode($product['name']) ?>"
             class="btn btn-primary btn-lg">📋 Request Wholesale Quote</a>
          <a href="/catalog?tab=<?= htmlspecialchars($product['category']) ?>"
             class="btn btn-outline">← Back to Catalog</a>
        </div>
      </div>

    </div><!-- /.product-detail__grid -->

    <!-- Related Products -->
    <?php if (!empty($related)): ?>
    <div style="margin-top:5rem">
      <h2 style="font-size:1.375rem;font-weight:800;color:var(--espresso);margin-bottom:2rem">
        Related Products
      </h2>
      <div class="products-grid">
        <?php
        // Reuse renderProductCard if available, otherwise simple fallback
        foreach ($related as $r):
        ?>
        <a href="/catalog/<?= htmlspecialchars($r['slug']) ?>"
           style="text-decoration:none"
           class="product-card product-card--<?= htmlspecialchars($r['category']) ?> fade-in">
          <div class="product-card__visual">
            <div class="product-card__visual-icon">
              <?= $r['category'] === 'green' ? '🌿' : '☕' ?>
            </div>
            <div class="product-card__origin-tag">📍 <?= htmlspecialchars($r['origin']) ?></div>
          </div>
          <div class="product-card__body">
            <div class="product-card__name"><?= htmlspecialchars($r['name']) ?></div>
            <div class="product-card__process"><?= htmlspecialchars(ucfirst($r['process'] ?? '')) ?></div>
            <div class="product-card__footer" style="margin-top:auto;padding-top:1rem;border-top:1px solid var(--border-light)">
              <div class="product-card__price">$<?= number_format((float)$r['price_per_kg'], 2) ?><span class="product-card__price-unit">/kg</span></div>
            </div>
          </div>
        </a>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endif; ?>

  </div>
</div>

<?php else: ?>
<!-- ── Full Catalog List Page ─────────────────────────────── -->

<!-- Page header -->
<div style="padding-top:calc(var(--space-24) + 80px);padding-bottom:var(--space-12);background:var(--espresso)">
  <div class="container">
    <span class="section-eyebrow" style="color:var(--gold)">Wholesale Products</span>
    <h1 class="section-title" style="color:var(--white);margin-top:0.5rem">
      Complete Coffee Catalog
    </h1>
    <p style="color:rgba(255,255,255,0.65);max-width:560px;line-height:1.7">
      <?= ($counts['green'] ?? 0) + ($counts['roasted'] ?? 0) ?> products available.
      Browse by category and download technical spec sheets.
      All prices FOB Tanjung Priok, Jakarta.
    </p>
  </div>
</div>

<!-- Search bar (standalone page only) -->
<div style="background:var(--cream);border-bottom:1px solid var(--border-light);padding:1.25rem 0">
  <div class="container">
    <div style="display:flex;align-items:center;gap:1rem;max-width:480px">
      <input type="search"
             id="catalog-search"
             placeholder="Search by origin, process, grade..."
             style="flex:1;padding:0.65rem 1rem;border:1px solid var(--border);border-radius:var(--radius-pill);font-size:0.9rem;background:var(--white)"
             aria-label="Search products">
      <span style="color:var(--text-muted);font-size:0.875rem">
        <?= ($counts['green'] ?? 0) + ($counts['roasted'] ?? 0) ?> products
      </span>
    </div>
  </div>
</div>

<!-- Catalog section (reuse partial) -->
<?php include ROOT_PATH . '/resources/views/partials/catalog.php'; ?>

<?php endif; ?>
