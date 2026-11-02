<?php
/**
 * Page: Homepage
 * Coffee Export B2B | AromaSource Global
 *
 * Variables injected by HomeController:
 *   $greenBeans, $roastedBeans, $testimonials, $warehouseImages, $appConfig
 */

$baseUrl = rtrim($appConfig['url'] ?? '', '/');
$stats   = $appConfig['stats'] ?? [];
$certs   = $appConfig['certifications'] ?? [];
?>

<!-- ══════════════════════════════════════════
     HERO SECTION
════════════════════════════════════════════ -->
<?php include ROOT_PATH . '/resources/views/partials/hero.php'; ?>

<!-- ══════════════════════════════════════════
     STATS BAR
════════════════════════════════════════════ -->
<section class="stats-bar" id="stats" aria-label="Company statistics">
  <div class="container">
    <div class="stats-bar__grid">
      <?php foreach ($stats as $stat): ?>
      <div class="stats-bar__item fade-in">
        <div class="stats-bar__value">
          <?= htmlspecialchars($stat['value']) ?>
        </div>
        <div class="stats-bar__label">
          <?= htmlspecialchars($stat['label']) ?>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ══════════════════════════════════════════
     PRODUCT CATALOG SECTION
════════════════════════════════════════════ -->
<?php include ROOT_PATH . '/resources/views/partials/catalog.php'; ?>

<!-- ══════════════════════════════════════════
     WHY CHOOSE US
════════════════════════════════════════════ -->
<section class="section section--cream" id="about" aria-labelledby="about-title">
  <div class="container">
    <div class="section-header fade-in">
      <span class="section-eyebrow">Why AromaSource</span>
      <h2 class="section-title" id="about-title">Built for Serious B2B Buyers</h2>
      <p class="section-subtitle" style="margin-inline:auto">
        We've spent 15 years perfecting our supply chain so you can focus on building
        your brand. Here's why 500+ partners choose us over the competition.
      </p>
    </div>

    <div class="features-grid">
      <?php
      $features = [
          ['icon'=>'🌍','title'=>'Direct-Origin Sourcing',
           'text'=>'We work directly with 200+ farmer cooperatives across Sumatra, Java, Sulawesi, and Ethiopia — cutting out middlemen and ensuring full traceability to farm level.'],
          ['icon'=>'🔬','title'=>'Q-Grader Quality Control',
           'text'=>'Every export lot is cupped and approved by SCA-certified Q-Graders in our on-site laboratory. We reject any lot that doesn\'t meet your target specification.'],
          ['icon'=>'🚢','title'=>'Reliable Export Logistics',
           'text'=>'Established relationships with all major shipping lines from Jakarta and Surabaya. FOB/CIF/EXW options. DHL Express available for samples up to 50kg.'],
          ['icon'=>'📋','title'=>'Complete Documentation',
           'text'=>'ISO 22000, phytosanitary certificates, organic certificates, chain-of-custody docs, and COA — all prepared in-house with no delays to your customs clearance.'],
          ['icon'=>'🏷️','title'=>'Private Label & Custom Roast',
           'text'=>'White-label roasted coffee programs with custom packaging design, nitrogen flushing, and valve bags. MOQ 50kg. Ideal for retail brands and café chains.'],
          ['icon'=>'🤝','title'=>'Dedicated Account Managers',
           'text'=>'Every partner gets a dedicated B2B account manager and a WhatsApp business line. Price negotiations, sample tracking, and shipment updates — all in one contact.'],
          ['icon'=>'📊','title'=>'Transparent Pricing & MOQs',
           'text'=>'No hidden fees. All pricing is FOB Tanjung Priok unless specified. MOQs range from 100kg (roasted) to 500kg (green), with volume discounts from 2MT+.'],
          ['icon'=>'♻️','title'=>'Sustainability Programme',
           'text'=>'Rainforest Alliance and UTZ certified. Carbon offset tracking available. Annual impact reports for partners who require ESG supply chain documentation.'],
      ];
      foreach ($features as $i => $f):
      ?>
      <div class="feature-card fade-in">
        <div class="feature-card__icon" aria-hidden="true"><?= $f['icon'] ?></div>
        <h3 class="feature-card__title"><?= htmlspecialchars($f['title']) ?></h3>
        <p class="feature-card__text"><?= htmlspecialchars($f['text']) ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ══════════════════════════════════════════
     WAREHOUSING SECTION
════════════════════════════════════════════ -->
<?php include ROOT_PATH . '/resources/views/partials/warehouse.php'; ?>

<!-- ══════════════════════════════════════════
     CERTIFICATIONS STRIP
════════════════════════════════════════════ -->
<section class="certifications" aria-label="Our certifications">
  <div class="container">
    <div class="certifications__label">Internationally Certified &amp; Compliant</div>
    <div class="certifications__logos">
      <?php
      $certIcons = ['ISO 22000:2018'=>'🏅','UTZ Certified'=>'🌱',
                    'Rainforest Alliance'=>'🐸','Fair Trade USA'=>'⚖️','USDA Organic'=>'🌿'];
      foreach ($certs as $cert):
        $icon = $certIcons[$cert] ?? '✓';
      ?>
      <div class="cert-badge">
        <span class="cert-badge__icon"><?= $icon ?></span>
        <span class="cert-badge__name"><?= htmlspecialchars($cert) ?></span>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ══════════════════════════════════════════
     TESTIMONIALS SECTION
════════════════════════════════════════════ -->
<?php include ROOT_PATH . '/resources/views/partials/testimonials.php'; ?>

<!-- ══════════════════════════════════════════
     CTA BANNER
════════════════════════════════════════════ -->
<section class="cta-banner" id="contact" aria-labelledby="cta-title">
  <div class="container">
    <div class="cta-banner__content">
      <h2 class="cta-banner__title" id="cta-title">
        Ready to Scale Your Coffee Program?
      </h2>
      <p class="cta-banner__text">
        Submit your wholesale inquiry and our B2B team will respond within 24 business hours
        with a customized pricing sheet, sample offer, and logistics proposal.
      </p>
      <div class="cta-banner__actions">
        <a href="/inquiry" class="btn btn-gold btn-lg">
          📋 Request Wholesale Quote
        </a>
        <a href="/catalog" class="btn btn-secondary btn-lg">
          Browse Full Catalog
        </a>
      </div>
      <p style="margin-top:1.5rem;color:rgba(255,255,255,0.5);font-size:0.8rem;">
        ✓ No commitment required &nbsp;·&nbsp;
        ✓ Free samples for qualified buyers &nbsp;·&nbsp;
        ✓ 24-hr response guarantee
      </p>
    </div>
  </div>
</section>
