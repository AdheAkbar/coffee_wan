<?php
/**
 * Partial: Footer
 * Coffee Export B2B | AromaSource Global
 *
 * Variables: $appConfig
 */
$contact = $appConfig['contact']        ?? [];
$social  = $appConfig['social']         ?? [];
$certs   = $appConfig['certifications'] ?? [];
$year    = date('Y');
?>
<footer class="footer" role="contentinfo">
  <div class="container">

    <div class="footer__grid">

      <!-- Brand Column -->
      <div>
        <div class="footer__brand-name">
          ☕ <?= htmlspecialchars($appConfig['name'] ?? 'AromaSource Global') ?>
        </div>
        <p class="footer__brand-text">
          <?= htmlspecialchars($appConfig['tagline'] ?? '') ?>.
          Connecting the world's finest Indonesian and East African coffee origins
          to wholesale buyers across 40+ countries since 2009.
        </p>
        <div class="footer__social">
          <a href="<?= htmlspecialchars($social['linkedin'] ?? '#') ?>"
             class="footer__social-link" aria-label="LinkedIn" target="_blank" rel="noopener">in</a>
          <a href="<?= htmlspecialchars($social['instagram'] ?? '#') ?>"
             class="footer__social-link" aria-label="Instagram" target="_blank" rel="noopener">📷</a>
          <a href="<?= htmlspecialchars($social['twitter'] ?? '#') ?>"
             class="footer__social-link" aria-label="Twitter/X" target="_blank" rel="noopener">𝕏</a>
        </div>
      </div>

      <!-- Products Column -->
      <div>
        <div class="footer__col-title">Products</div>
        <ul class="footer__links">
          <li><a href="/catalog?tab=green"   class="footer__link">Premium Green Beans</a></li>
          <li><a href="/catalog?tab=roasted" class="footer__link">Freshly Roasted Beans</a></li>
          <li><a href="/catalog"             class="footer__link">Full Product Catalog</a></li>
          <li><a href="/inquiry"             class="footer__link">Request Sample</a></li>
          <li><a href="/inquiry"             class="footer__link">Wholesale Pricing</a></li>
        </ul>
      </div>

      <!-- Certifications Column -->
      <div>
        <div class="footer__col-title">Certifications</div>
        <ul class="footer__links">
          <?php foreach ($certs as $cert): ?>
          <li><span class="footer__link">✓ <?= htmlspecialchars($cert) ?></span></li>
          <?php endforeach; ?>
        </ul>
      </div>

      <!-- Contact Column -->
      <div>
        <div class="footer__col-title">Contact</div>
        <?php if (!empty($contact['address'])): ?>
        <div class="footer__contact-item">
          <span class="footer__contact-icon">📍</span>
          <span><?= htmlspecialchars($contact['address']) ?></span>
        </div>
        <?php endif; ?>
        <?php if (!empty($contact['phone'])): ?>
        <div class="footer__contact-item">
          <span class="footer__contact-icon">📞</span>
          <a href="tel:<?= preg_replace('/\s/', '', $contact['phone']) ?>"
             style="color:inherit">
            <?= htmlspecialchars($contact['phone']) ?>
          </a>
        </div>
        <?php endif; ?>
        <?php if (!empty($contact['email'])): ?>
        <div class="footer__contact-item">
          <span class="footer__contact-icon">✉️</span>
          <a href="mailto:<?= htmlspecialchars($contact['email']) ?>"
             style="color:inherit">
            <?= htmlspecialchars($contact['email']) ?>
          </a>
        </div>
        <?php endif; ?>
        <?php if (!empty($contact['whatsapp'])): ?>
        <div class="footer__contact-item">
          <span class="footer__contact-icon">💬</span>
          <a href="https://wa.me/<?= preg_replace('/\D/', '', $contact['whatsapp']) ?>"
             target="_blank" rel="noopener" style="color:inherit">
            WhatsApp Business
          </a>
        </div>
        <?php endif; ?>
      </div>

    </div><!-- /.footer__grid -->

    <!-- Bottom bar -->
    <div class="footer__bottom">
      <p>© <?= $year ?> <?= htmlspecialchars($appConfig['name'] ?? 'AromaSource Global') ?>. All rights reserved.</p>
      <div class="footer__certifications">
        <?php foreach ($certs as $cert): ?>
        <span class="footer__cert-chip"><?= htmlspecialchars($cert) ?></span>
        <?php endforeach; ?>
      </div>
    </div>

  </div>
</footer>
