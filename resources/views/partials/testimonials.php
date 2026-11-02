<?php
/**
 * Partial: Testimonials Section
 * Coffee Export B2B | AromaSource Global
 *
 * Variables: $testimonials (array)
 */

// Group testimonials into pages of 3
$perPage = 3;
$pages   = array_chunk($testimonials ?? [], $perPage);
?>

<section class="testimonials-section section" id="testimonials"
         aria-labelledby="testimonials-title">
  <div class="container">

    <!-- Section Header -->
    <div class="section-header fade-in">
      <span class="section-eyebrow">Client Reviews</span>
      <h2 class="section-title" id="testimonials-title">
        What Our Wholesale Partners Say
      </h2>
      <p class="section-subtitle" style="margin-inline:auto">
        Trusted by importers, roasters, distributors, and café chains across 40+ countries.
        Here's what some of our long-term B2B partners have to say.
      </p>
    </div>

    <!-- Carousel -->
    <div class="carousel fade-in" role="region" aria-label="Client testimonials" aria-roledescription="carousel">

      <!-- Progress bar (auto-advance indicator) -->
      <div class="carousel__progress" aria-hidden="true">
        <div class="carousel__progress-fill"></div>
      </div>

      <!-- Track -->
      <div class="carousel__track" aria-live="polite">

        <?php if (!empty($pages)): ?>
          <?php foreach ($pages as $pageIdx => $group): ?>
          <div class="carousel__slide"
               role="group"
               aria-label="Slide <?= $pageIdx + 1 ?> of <?= count($pages) ?>"
               aria-roledescription="slide">
            <div class="carousel__slide-inner">
              <?php foreach ($group as $t): ?>
              <?php
                $ratingVal = (int)($t['rating'] ?? 5);
                $ratingVal = max(1, min(5, $ratingVal));
              ?>
              <article class="testimonial-card">

                <!-- Stars -->
                <div class="stars" role="img" aria-label="Rating: <?= $ratingVal ?> out of 5">
                  <?php for ($s = 1; $s <= 5; $s++): ?>
                  <span class="star <?= $s <= $ratingVal ? 'filled' : 'empty' ?>">
                    <?= $s <= $ratingVal ? '★' : '☆' ?>
                  </span>
                  <?php endfor; ?>
                </div>

                <!-- Quote -->
                <blockquote class="testimonial-card__quote">
                  "<?= htmlspecialchars($t['quote'] ?? '') ?>"
                </blockquote>

                <!-- Volume badge -->
                <?php if (!empty($t['volume_per_year'])): ?>
                <div class="testimonial-card__volume">
                  📦 <?= htmlspecialchars($t['volume_per_year']) ?>
                </div>
                <?php endif; ?>

                <!-- Client info -->
                <div class="testimonial-card__client">
                  <div class="testimonial-card__logo" aria-hidden="true">
                    <div class="company-initials">
                      <?php
                        $words = array_filter(explode(' ', $t['company_name'] ?? ''));
                        echo count($words) >= 2
                          ? strtoupper(substr($words[0], 0, 1) . substr(array_values($words)[1], 0, 1))
                          : strtoupper(substr($t['company_name'] ?? '??', 0, 2));
                      ?>
                    </div>
                  </div>
                  <div class="testimonial-card__client-info">
                    <div class="testimonial-card__name">
                      <?= htmlspecialchars($t['client_name'] ?? '') ?>
                    </div>
                    <?php if (!empty($t['client_title'])): ?>
                    <div class="testimonial-card__title">
                      <?= htmlspecialchars($t['client_title']) ?>
                    </div>
                    <?php endif; ?>
                    <div class="testimonial-card__company">
                      <?= htmlspecialchars($t['company_name'] ?? '') ?>
                    </div>
                    <div class="testimonial-card__country">
                      <?= htmlspecialchars($t['company_country'] ?? '') ?>
                    </div>
                  </div>
                  <?php if (!empty($t['partnership_since'])): ?>
                  <div class="testimonial-card__since">
                    <div class="testimonial-card__since-label">Partner since</div>
                    <div class="testimonial-card__since-year">
                      <?= htmlspecialchars((string)$t['partnership_since']) ?>
                    </div>
                  </div>
                  <?php endif; ?>
                </div>

              </article>
              <?php endforeach; ?>
            </div>
          </div>
          <?php endforeach; ?>

        <?php else: ?>
          <!-- Skeleton placeholders -->
          <div class="carousel__slide">
            <div class="carousel__slide-inner">
              <?php for ($i = 0; $i < 3; $i++): ?>
              <div class="testimonial-skeleton">
                <div class="skeleton-line skeleton-line--short"></div>
                <div class="skeleton-line skeleton-line--long"></div>
                <div class="skeleton-line skeleton-line--long"></div>
                <div class="skeleton-line skeleton-line--medium"></div>
                <div style="flex:1"></div>
                <div class="skeleton-line skeleton-line--short"></div>
              </div>
              <?php endfor; ?>
            </div>
          </div>
        <?php endif; ?>

      </div><!-- /.carousel__track -->

      <!-- Controls -->
      <div class="carousel__controls">
        <button class="carousel__btn carousel__btn--prev"
                aria-label="Previous testimonials">&#8592;</button>
        <div class="carousel__dots" role="tablist" aria-label="Carousel navigation"></div>
        <button class="carousel__btn carousel__btn--next"
                aria-label="Next testimonials">&#8594;</button>
      </div>

    </div><!-- /.carousel -->

    <!-- Summary stats -->
    <div class="text-center fade-in" style="margin-top:3rem;">
      <p style="color:var(--text-muted);font-size:0.9rem;">
        ⭐ <strong>4.9/5</strong> average rating from <?= number_format(count($testimonials ?? [])) ?>+ verified wholesale partners
        &nbsp;·&nbsp;
        <a href="/inquiry" style="color:var(--forest);font-weight:600;">Become a partner →</a>
      </p>
    </div>

  </div>
</section>
