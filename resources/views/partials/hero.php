<?php
/**
 * Partial: Hero Section
 * Coffee Export B2B | AromaSource Global
 *
 * Variables: $appConfig, $greenBeans (array), $roastedBeans (array)
 */
$baseUrl = rtrim($appConfig['url'] ?? '', '/');
$stats   = $appConfig['stats'] ?? [];

// Preview: top 2 green + 1 roasted for the hero card
$heroGreen   = array_slice($greenBeans   ?? [], 0, 2);
$heroRoasted = array_slice($roastedBeans ?? [], 0, 1);
$heroPrev    = array_merge($heroGreen, $heroRoasted);
?>

<section class="hero" id="hero" aria-label="Hero — AromaSource Global">

  <!-- Background -->
  <div class="hero__bg" aria-hidden="true">
    <div class="hero__bg-gradient"></div>
    <div class="hero__beans">
      <div class="hero__bean hero__bean--1"></div>
      <div class="hero__bean hero__bean--2"></div>
      <div class="hero__bean hero__bean--3"></div>
      <div class="hero__bean hero__bean--4"></div>
      <div class="hero__bean hero__bean--5"></div>
    </div>
    <div class="hero__grid-overlay"></div>
  </div>

  <!-- Content -->
  <div class="hero__content">
    <div class="container">
      <div class="hero__inner">

        <!-- Copy -->
        <div class="hero__copy">
          <div class="hero__eyebrow">
            🌍 &nbsp; Trusted by 500+ Wholesale Partners Worldwide
          </div>

          <h1 class="hero__title">
            Premium <em>Coffee Export</em><br>
            From Origin to Your<br>Roastery
          </h1>

          <p class="hero__subtitle">
            We connect the world's finest Indonesian and East African coffee origins
            directly to wholesale buyers — green beans and freshly roasted. ISO 22000
            certified. Reliable. Traceable. Scalable.
          </p>

          <div class="hero__actions">
            <a href="/inquiry" class="btn btn-gold btn-lg">
              📋 Request Wholesale Quote
            </a>
            <a href="/catalog" class="btn btn-secondary btn-lg">
              View Full Catalog →
            </a>
          </div>

          <!-- Trust signals -->
          <div class="hero__trust">
            <div class="hero__trust-item">✓ ISO 22000:2018</div>
            <div class="hero__trust-dot"></div>
            <div class="hero__trust-item">✓ UTZ Certified</div>
            <div class="hero__trust-dot"></div>
            <div class="hero__trust-item">✓ Fair Trade USA</div>
            <div class="hero__trust-dot"></div>
            <div class="hero__trust-item">✓ 40+ Countries</div>
          </div>
        </div>

        <!-- Visual Panel -->
        <div class="hero__visual" aria-hidden="true">

          <!-- Product preview card -->
          <div class="hero__card">
            <div class="hero__card-label">🌿 Featured Products</div>
            <div class="hero__product-preview">
              <?php foreach ($heroPrev as $prod): ?>
              <a href="/catalog/<?= htmlspecialchars($prod['slug']) ?>"
                 class="hero__product-item" style="text-decoration:none">
                <div class="hero__product-icon hero__product-icon--<?= $prod['category'] ?>">
                  <?= $prod['category'] === 'green' ? '🌿' : '☕' ?>
                </div>
                <div>
                  <div class="hero__product-name"><?= htmlspecialchars($prod['name']) ?></div>
                  <div class="hero__product-meta">
                    <?= htmlspecialchars($prod['origin']) ?>
                    <?php if (!empty($prod['grade'])): ?>
                    · <?= htmlspecialchars($prod['grade']) ?>
                    <?php endif; ?>
                  </div>
                </div>
                <div class="hero__product-price">
                  <span class="hero__product-price-val">
                    $<?= number_format((float)($prod['price_per_kg'] ?? 0), 2) ?>/kg
                  </span>
                  <span class="hero__product-price-moq">
                    MOQ <?= number_format((int)($prod['moq_kg'] ?? 0)) ?>kg
                  </span>
                </div>
              </a>
              <?php endforeach; ?>
            </div>
          </div>

          <!-- Floating stat chip -->
          <div class="hero__stat-chip">
            <div class="hero__stat-chip-value">500+</div>
            <div class="hero__stat-chip-label">Active Wholesale Partners</div>
          </div>

        </div><!-- /.hero__visual -->

      </div><!-- /.hero__inner -->
    </div><!-- /.container -->
  </div><!-- /.hero__content -->

  <!-- Scroll indicator -->
  <div class="hero__scroll" aria-hidden="true">
    <span class="hero__scroll-label">Scroll</span>
    <div class="hero__scroll-line"></div>
  </div>

</section>
