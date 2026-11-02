<?php
/**
 * Partial: Warehousing Section
 * Coffee Export B2B | AromaSource Global
 *
 * Variables: $warehouseImages (array from HomeController)
 */
?>

<section class="warehouse-section section" id="warehousing" aria-labelledby="warehousing-title">
  <div class="container">

    <!-- Section Header -->
    <div class="section-header fade-in">
      <span class="section-eyebrow">Infrastructure</span>
      <h2 class="section-title" id="warehousing-title">
        World-Class Warehousing &amp; QC
      </h2>
      <p class="section-subtitle" style="margin-inline:auto">
        Our export facility combines ISO 22000-certified climate control, hermetic storage,
        and Q-Grader supervised quality control — ensuring every shipment meets your
        strictest specifications.
      </p>
    </div>

    <!-- Warehouse Grid -->
    <div class="warehouse-grid">
      <?php foreach ($warehouseImages ?? [] as $i => $facility): ?>
      <article class="warehouse-card warehouse-card--<?= htmlspecialchars($facility['css_theme']) ?> fade-in"
               role="article"
               aria-label="<?= htmlspecialchars($facility['title']) ?>">

        <!-- CSS-illustrated image -->
        <div class="warehouse-card__image" aria-hidden="true"></div>

        <!-- Content overlay -->
        <div class="warehouse-card__content">
          <div class="warehouse-card__icon" aria-hidden="true">
            <?= htmlspecialchars($facility['icon']) ?>
          </div>
          <h3 class="warehouse-card__title"><?= htmlspecialchars($facility['title']) ?></h3>
          <p class="warehouse-card__description"><?= htmlspecialchars($facility['description']) ?></p>
          <div class="warehouse-card__spec">⚙️ <?= htmlspecialchars($facility['spec']) ?></div>
        </div>

      </article>
      <?php endforeach; ?>
    </div>

    <!-- Capacity Data Strip -->
    <div class="warehouse-capacity fade-in">
      <div class="capacity-item">
        <div class="capacity-item__value"
             data-counter="500" data-counter-suffix=" MT">500 MT</div>
        <div class="capacity-item__label">Storage Capacity</div>
      </div>
      <div class="capacity-divider" aria-hidden="true"></div>
      <div class="capacity-item">
        <div class="capacity-item__value"
             data-counter="3" data-counter-suffix=" MT/hr">3 MT/hr</div>
        <div class="capacity-item__label">Sorting Line Speed</div>
      </div>
      <div class="capacity-divider" aria-hidden="true"></div>
      <div class="capacity-item">
        <div class="capacity-item__value"
             data-counter="24" data-counter-suffix="/7">24/7</div>
        <div class="capacity-item__label">Operations</div>
      </div>
      <div class="capacity-divider" aria-hidden="true"></div>
      <div class="capacity-item">
        <div class="capacity-item__value"
             data-counter="99.8" data-counter-suffix="%">99.8%</div>
        <div class="capacity-item__label">QC Pass Rate</div>
      </div>
      <div class="capacity-divider" aria-hidden="true"></div>
      <div class="capacity-item">
        <div class="capacity-item__value"
             data-counter="12" data-counter-suffix=" mo">12 mo</div>
        <div class="capacity-item__label">Max Storage Life</div>
      </div>
    </div>

    <!-- Certification note -->
    <p class="text-center fade-in" style="margin-top:2.5rem;color:rgba(255,255,255,0.45);font-size:0.875rem;">
      ✓ ISO 22000:2018 Certified Facility &nbsp;·&nbsp;
      ✓ BPOM Registered &nbsp;·&nbsp;
      ✓ Phytosanitary Certified &nbsp;·&nbsp;
      ✓ Real-time shipment tracking
    </p>

  </div>
</section>
