<?php
/**
 * Partial: Product Catalog Section
 * Coffee Export B2B | AromaSource Global
 *
 * Variables: $greenBeans, $roastedBeans, $appConfig
 */

$gCount = count($greenBeans   ?? []);
$rCount = count($roastedBeans ?? []);

/**
 * Render a product card HTML.
 */
function renderProductCard(array $p, bool $full = false): string
{
    $baseUrl = rtrim($GLOBALS['appConfig']['url'] ?? '', '/');
    $cat     = $p['category'] ?? 'green';
    $slug    = htmlspecialchars($p['slug']         ?? '');
    $name    = htmlspecialchars($p['name']         ?? '');
    $origin  = htmlspecialchars($p['origin']       ?? '');
    $process = htmlspecialchars(ucfirst($p['process'] ?? ''));
    $grade   = htmlspecialchars($p['grade']        ?? '');
    $screen  = htmlspecialchars($p['screen_size']  ?? '');
    $moisture= htmlspecialchars($p['moisture_pct'] ?? '');
    $roastLv = htmlspecialchars(ucwords($p['roast_level'] ?? ''));
    $score   = (float)($p['cupping_score']    ?? 0);
    $price   = (float)($p['price_per_kg']     ?? 0);
    $moq     = (int)  ($p['moq_kg']           ?? 0);
    $lead    = (int)  ($p['lead_days']        ?? 14);
    $badge   = htmlspecialchars($p['badge']   ?? '');
    $flavor  = htmlspecialchars($p['flavor_notes'] ?? '');
    $icon    = $cat === 'green' ? '🌿' : '☕';

    // Flavor chips (comma-separated)
    $chips   = '';
    if ($flavor) {
        foreach (array_slice(explode(',', $flavor), 0, 3) as $note) {
            $chips .= '<span class="flavor-chip">' . htmlspecialchars(trim($note)) . '</span>';
        }
    }

    // Score bar width
    $scorePct = $score > 0 ? round(($score - 60) / 40 * 100, 1) : 0;

    // Badge HTML
    $badgeHtml = $badge
        ? '<div class="product-card__badge"><span class="badge badge-gold">' . $badge . '</span></div>'
        : '';

    // Category-specific spec rows
    $specRows = '';
    if ($cat === 'green') {
        if ($grade)    $specRows .= '<div class="spec-row"><span class="spec-label">Grade</span><span class="spec-value">' . $grade . '</span></div>';
        if ($screen)   $specRows .= '<div class="spec-row"><span class="spec-label">Screen</span><span class="spec-value">' . $screen . '</span></div>';
        if ($moisture) $specRows .= '<div class="spec-row"><span class="spec-label">Moisture</span><span class="spec-value">' . $moisture . '%</span></div>';
    } else {
        if ($roastLv)  $specRows .= '<div class="spec-row"><span class="spec-label">Roast</span><span class="spec-value">' . $roastLv . '</span></div>';
        if ($process)  $specRows .= '<div class="spec-row"><span class="spec-label">Process</span><span class="spec-value">' . $process . '</span></div>';
    }
    $specRows .= '<div class="spec-row"><span class="spec-label">MOQ</span><span class="spec-value">' . number_format($moq) . ' kg</span></div>';
    $specRows .= '<div class="spec-row"><span class="spec-label">Lead Time</span><span class="spec-value">' . $lead . ' days</span></div>';

    $scoreHtml = $score > 0
        ? '<div class="product-card__score">
            <span>Q Score</span>
            <div class="score-bar"><div class="score-fill" data-score="' . $score . '" style="width:0"></div></div>
            <span class="score-num">' . $score . '</span>
           </div>'
        : '';

    return '<article class="product-card product-card--' . $cat . ' fade-in">
      <a href="/catalog/' . $slug . '" tabindex="-1" aria-hidden="true">
        <div class="product-card__visual">
          <div class="product-card__visual-icon">' . $icon . '</div>
          <div class="product-card__origin-tag">📍 ' . $origin . '</div>
          ' . $badgeHtml . '
        </div>
      </a>
      <div class="product-card__body">
        <div class="product-card__name">
          <a href="/catalog/' . $slug . '" style="color:inherit;text-decoration:none;">' . $name . '</a>
        </div>
        <div class="product-card__process">' . $process . '</div>
        <div class="product-card__flavor">' . $chips . '</div>
        ' . $scoreHtml . '
        <div class="product-card__specs">' . $specRows . '</div>
        <div class="product-card__footer">
          <div class="product-card__pricing">
            <div class="product-card__price">
              $' . number_format($price, 2) . '
              <span class="product-card__price-unit">/kg FOB</span>
            </div>
            <div class="product-card__moq">Min. order: ' . number_format($moq) . ' kg</div>
          </div>
          <a href="/inquiry?product=' . urlencode($p['name'] ?? '') . '"
             class="btn btn-primary btn-sm btn-quote-quick"
             data-product="' . $name . '">
            Get Quote
          </a>
        </div>
      </div>
    </article>';
}
?>

<section class="catalog-section" id="catalog" aria-labelledby="catalog-title">
  <div class="container">

    <!-- Section Header -->
    <div class="section-header fade-in">
      <span class="section-eyebrow">Our Products</span>
      <h2 class="section-title" id="catalog-title">
        Wholesale Coffee Catalog
      </h2>
      <p class="section-subtitle" style="margin-inline:auto">
        Sourced from Indonesia's finest growing regions and East Africa's premier origins.
        Full technical specs and wholesale pricing for qualified B2B buyers.
      </p>
    </div>

    <!-- Tab Navigation -->
    <div class="catalog__tabs" role="tablist" aria-label="Product categories">
      <button class="catalog__tab active"
              role="tab"
              id="tab-green"
              data-tab="green"
              aria-controls="panel-green"
              aria-selected="true">
        🌿 Premium Green Beans
        <span class="tab-count"><?= $gCount ?></span>
      </button>
      <button class="catalog__tab"
              role="tab"
              id="tab-roasted"
              data-tab="roasted"
              aria-controls="panel-roasted"
              aria-selected="false">
        ☕ Freshly Roasted Beans
        <span class="tab-count"><?= $rCount ?></span>
      </button>
    </div>

    <!-- ── Panel: Green Beans ──────────────────────────────────── -->
    <div class="catalog__panel active"
         id="panel-green"
         role="tabpanel"
         aria-labelledby="tab-green">

      <div class="catalog__panel-header">
        <div>
          <div class="catalog__panel-title">🌿 Premium Green Beans</div>
          <div class="catalog__panel-subtitle">
            Washed · Natural · Honey · Wet-Hulled — Grade 1 Specialty &amp; Commercial Lots
          </div>
        </div>
        <a href="/catalog?tab=green" class="btn btn-outline btn-sm">View All Green →</a>
      </div>

      <div class="products-grid" id="green-grid">
        <?php if (!empty($greenBeans)): ?>
          <?php foreach ($greenBeans as $p): ?>
            <?= renderProductCard($p) ?>
          <?php endforeach; ?>
        <?php else: ?>
          <div class="catalog-empty">
            <div class="catalog-empty__icon">🌿</div>
            <div class="catalog-empty__title">No green beans available</div>
            <p>Check back soon or <a href="/inquiry">contact us</a> for custom sourcing.</p>
          </div>
        <?php endif; ?>
      </div>
    </div>

    <!-- ── Panel: Roasted Beans ──────────────────────────────────── -->
    <div class="catalog__panel"
         id="panel-roasted"
         role="tabpanel"
         aria-labelledby="tab-roasted">

      <div class="catalog__panel-header">
        <div>
          <div class="catalog__panel-title">☕ Freshly Roasted Beans</div>
          <div class="catalog__panel-subtitle">
            Light · Medium · Dark — Roasted-to-order with 48–72hr dispatch. Private label available.
          </div>
        </div>
        <a href="/catalog?tab=roasted" class="btn btn-outline btn-sm">View All Roasted →</a>
      </div>

      <div class="products-grid" id="roasted-grid">
        <?php if (!empty($roastedBeans)): ?>
          <?php foreach ($roastedBeans as $p): ?>
            <?= renderProductCard($p) ?>
          <?php endforeach; ?>
        <?php else: ?>
          <div class="catalog-empty">
            <div class="catalog-empty__icon">☕</div>
            <div class="catalog-empty__title">No roasted beans available</div>
            <p>Contact us for custom roasting programs.</p>
          </div>
        <?php endif; ?>
      </div>
    </div>

    <!-- Bottom CTA -->
    <div class="text-center" style="margin-top:3rem;">
      <a href="/inquiry" class="btn btn-primary btn-lg">
        📋 Request Wholesale Quote for Any Product
      </a>
      <p style="margin-top:1rem;color:var(--text-muted);font-size:0.875rem;">
        We respond to all B2B inquiries within 24 business hours.
      </p>
    </div>

  </div>
</section>
