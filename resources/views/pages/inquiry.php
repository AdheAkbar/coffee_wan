<?php
/**
 * Page: Wholesale Inquiry Form
 * Coffee Export B2B | AromaSource Global
 *
 * Variables: $products, $errors, $old, $submitted (bool), $refId, $appConfig
 */

$errors    = $errors    ?? [];
$old       = $old       ?? [];
$submitted = $submitted ?? false;
$refId     = $refId     ?? '';

$countries = ['Australia','Austria','Belgium','Brazil','Canada','China','Denmark',
              'Finland','France','Germany','Hong Kong','India','Indonesia','Ireland',
              'Italy','Japan','Malaysia','Mexico','Netherlands','New Zealand',
              'Norway','Philippines','Poland','Singapore','South Korea','Spain',
              'Sweden','Switzerland','Thailand','United Arab Emirates',
              'United Kingdom','United States','Vietnam','Other'];

$companyTypes = [
    'importer'    => 'Coffee Importer / Trader',
    'roaster'     => 'Coffee Roaster',
    'distributor' => 'Distributor / Wholesaler',
    'retailer'    => 'Specialty Retailer',
    'cafe_chain'  => 'Café Chain / Restaurant Group',
    'other'       => 'Other',
];

$incoterms = ['FOB'=>'FOB (Free On Board)','CIF'=>'CIF (Cost, Insurance & Freight)',
              'EXW'=>'EXW (Ex Works)','DAP'=>'DAP (Delivered At Place)'];
?>

<!-- Page Header -->
<div style="padding-top:calc(var(--space-24) + 80px);padding-bottom:var(--space-12);background:var(--espresso)">
  <div class="container">
    <span class="section-eyebrow" style="color:var(--gold)">Wholesale Inquiry</span>
    <h1 class="section-title" style="color:var(--white);margin-top:0.5rem">
      Request Your Wholesale Quote
    </h1>
    <p style="color:rgba(255,255,255,0.65);max-width:520px;line-height:1.7">
      Fill in the details below and our B2B team will respond within 24 business hours
      with a customized pricing sheet, sample availability, and logistics proposal.
    </p>
  </div>
</div>

<section style="padding-block:var(--space-16);background:var(--cream)">
  <div class="container">

    <?php if ($submitted): ?>
    <!-- ── Success State ──────────────────────────────────── -->
    <div style="max-width:560px;margin:0 auto;text-align:center;padding:var(--space-16) var(--space-8);
                background:var(--white);border-radius:var(--radius-xl);border:1px solid var(--border-light);
                box-shadow:var(--shadow)">
      <div style="font-size:4rem;margin-bottom:1.5rem">✅</div>
      <h2 style="font-size:1.75rem;font-weight:800;color:var(--espresso);margin-bottom:1rem">
        Inquiry Received!
      </h2>
      <p style="color:var(--text-muted);line-height:1.7;margin-bottom:0.5rem">
        Thank you for your wholesale inquiry. Our B2B team has received your request
        <?php if ($refId): ?>
        (Ref: <strong>#<?= htmlspecialchars($refId) ?></strong>)
        <?php endif; ?>
        and will contact you within <strong>24 business hours</strong>.
      </p>
      <p style="color:var(--text-muted);font-size:0.875rem;margin-bottom:2rem">
        For urgent inquiries, please WhatsApp us at
        <a href="https://wa.me/<?= preg_replace('/\D/','', $appConfig['contact']['whatsapp'] ?? '') ?>"
           style="color:var(--forest);font-weight:600">
          <?= htmlspecialchars($appConfig['contact']['whatsapp'] ?? '') ?>
        </a>
      </p>
      <div style="display:flex;gap:1rem;justify-content:center;flex-wrap:wrap">
        <a href="/" class="btn btn-primary">Back to Homepage</a>
        <a href="/catalog" class="btn btn-outline">Browse Catalog</a>
      </div>
    </div>

    <?php else: ?>
    <!-- ── Inquiry Form ───────────────────────────────────── -->
    <div style="display:grid;grid-template-columns:2fr 1fr;gap:var(--space-10);align-items:start">

      <!-- Form -->
      <form method="POST" action="/inquiry" novalidate
            style="background:var(--white);border-radius:var(--radius-xl);padding:var(--space-8);
                   border:1px solid var(--border-light);box-shadow:var(--shadow-sm)">

        <!-- Global error -->
        <?php if (!empty($errors)): ?>
        <div style="background:#fef2f2;border:1px solid #fecaca;border-radius:var(--radius);
                    padding:1rem;margin-bottom:1.5rem;color:var(--error);font-size:0.875rem">
          ⚠️ Please correct the errors below before submitting.
        </div>
        <?php endif; ?>

        <!-- ─ Company Information ─ -->
        <div style="margin-bottom:2rem">
          <h2 style="font-size:1rem;font-weight:700;color:var(--espresso);margin-bottom:1.25rem;
                     padding-bottom:0.5rem;border-bottom:2px solid var(--cream)">
            🏢 Company Information
          </h2>
          <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
            <?php // field() helper is defined below in this same file ?>
            <?php function field(string $name, string $label, string $type='text',
                                 array $old=[], array $errors=[], array $attrs=[]): void {
              $val = htmlspecialchars($old[$name] ?? '');
              $err = $errors[$name] ?? '';
              $attStr = '';
              foreach ($attrs as $k => $v) $attStr .= " {$k}=\"" . htmlspecialchars($v) . '"';
              $errStyle = $err ? 'border-color:var(--error)' : '';
              echo '<div style="grid-column:' . ($attrs['full'] ?? false ? 'span 2' : 'span 1') . '">';
              echo '<label style="display:block;font-size:0.82rem;font-weight:600;color:var(--espresso);margin-bottom:0.4rem">'
                   . htmlspecialchars($label) . ($attrs['required'] ?? false ? ' <span style="color:var(--error)">*</span>' : '') . '</label>';
              echo '<input type="' . $type . '" name="' . $name . '" value="' . $val . '"'
                   . ' style="width:100%;padding:0.65rem 1rem;border:1.5px solid var(--border);'
                   . 'border-radius:var(--radius);font-size:0.9rem;' . $errStyle . '"' . $attStr . '>';
              if ($err) echo '<div style="color:var(--error);font-size:0.78rem;margin-top:0.3rem">' . htmlspecialchars($err) . '</div>';
              echo '</div>';
            } ?>

            <?php field('company_name', 'Company Name', 'text', $old, $errors, ['required'=>'true','placeholder'=>'Röstwerk Hamburg GmbH']); ?>
            <?php field('company_website', 'Website', 'url', $old, $errors, ['placeholder'=>'https://yourcompany.com']); ?>

            <!-- Country select -->
            <div>
              <label style="display:block;font-size:0.82rem;font-weight:600;color:var(--espresso);margin-bottom:0.4rem">
                Country <span style="color:var(--error)">*</span>
              </label>
              <select name="company_country"
                      style="width:100%;padding:0.65rem 1rem;border:1.5px solid var(--border);
                             border-radius:var(--radius);font-size:0.9rem;background:var(--white);
                             <?= isset($errors['company_country']) ? 'border-color:var(--error)' : '' ?>">
                <option value="">Select country...</option>
                <?php foreach ($countries as $c): ?>
                <option value="<?= htmlspecialchars($c) ?>"
                        <?= (($old['company_country'] ?? '') === $c) ? 'selected' : '' ?>>
                  <?= htmlspecialchars($c) ?>
                </option>
                <?php endforeach; ?>
              </select>
              <?php if (!empty($errors['company_country'])): ?>
              <div style="color:var(--error);font-size:0.78rem;margin-top:0.3rem">
                <?= htmlspecialchars($errors['company_country']) ?>
              </div>
              <?php endif; ?>
            </div>

            <!-- Company type select -->
            <div>
              <label style="display:block;font-size:0.82rem;font-weight:600;color:var(--espresso);margin-bottom:0.4rem">
                Company Type
              </label>
              <select name="company_type"
                      style="width:100%;padding:0.65rem 1rem;border:1.5px solid var(--border);
                             border-radius:var(--radius);font-size:0.9rem;background:var(--white)">
                <?php foreach ($companyTypes as $val => $label): ?>
                <option value="<?= $val ?>"
                        <?= (($old['company_type'] ?? 'other') === $val) ? 'selected' : '' ?>>
                  <?= htmlspecialchars($label) ?>
                </option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
        </div>

        <!-- ─ Contact Information ─ -->
        <div style="margin-bottom:2rem">
          <h2 style="font-size:1rem;font-weight:700;color:var(--espresso);margin-bottom:1.25rem;
                     padding-bottom:0.5rem;border-bottom:2px solid var(--cream)">
            👤 Contact Information
          </h2>
          <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
            <?php field('contact_name',  'Full Name', 'text', $old, $errors, ['required'=>'true','placeholder'=>'Thomas Müller']); ?>
            <?php field('contact_title', 'Job Title', 'text', $old, $errors, ['placeholder'=>'Head of Procurement']); ?>
            <?php field('email', 'Business Email', 'email', $old, $errors, ['required'=>'true','placeholder'=>'t.muller@company.com']); ?>
            <?php field('phone', 'Phone / WhatsApp', 'tel', $old, $errors, ['placeholder'=>'+49 40 1234 5678']); ?>
          </div>
        </div>

        <!-- ─ Product Interest ─ -->
        <div style="margin-bottom:2rem">
          <h2 style="font-size:1rem;font-weight:700;color:var(--espresso);margin-bottom:1.25rem;
                     padding-bottom:0.5rem;border-bottom:2px solid var(--cream)">
            ☕ Product Interest
          </h2>
          <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">

            <!-- Category interest -->
            <div>
              <label style="display:block;font-size:0.82rem;font-weight:600;color:var(--espresso);margin-bottom:0.4rem">
                Category of Interest
              </label>
              <div style="display:flex;gap:1rem">
                <label style="display:flex;align-items:center;gap:0.5rem;font-size:0.9rem;cursor:pointer">
                  <input type="radio" name="category_interest" value="green"
                         <?= ($old['category_interest'] ?? 'green') === 'green' ? 'checked' : '' ?>>
                  🌿 Green Beans
                </label>
                <label style="display:flex;align-items:center;gap:0.5rem;font-size:0.9rem;cursor:pointer">
                  <input type="radio" name="category_interest" value="roasted"
                         <?= ($old['category_interest'] ?? '') === 'roasted' ? 'checked' : '' ?>>
                  ☕ Roasted Beans
                </label>
                <label style="display:flex;align-items:center;gap:0.5rem;font-size:0.9rem;cursor:pointer">
                  <input type="radio" name="category_interest" value="both"
                         <?= ($old['category_interest'] ?? '') === 'both' ? 'checked' : '' ?>>
                  Both
                </label>
              </div>
            </div>

            <?php field('monthly_volume_kg', 'Monthly Volume (kg)', 'number', $old, $errors,
                        ['placeholder'=>'e.g. 5000','min'=>'0']); ?>

            <!-- Product interest textarea -->
            <div style="grid-column:span 2">
              <label style="display:block;font-size:0.82rem;font-weight:600;color:var(--espresso);margin-bottom:0.4rem">
                Specific Products of Interest <span style="color:var(--error)">*</span>
              </label>
              <select name="product_interest"
                      style="width:100%;padding:0.65rem 1rem;border:1.5px solid var(--border);
                             border-radius:var(--radius);font-size:0.9rem;background:var(--white);
                             <?= isset($errors['product_interest']) ? 'border-color:var(--error)' : '' ?>">
                <option value="">Select a product...</option>
                <optgroup label="🌿 Premium Green Beans">
                  <?php foreach (($products ?? []) as $p): if ($p['category'] !== 'green') continue; ?>
                  <option value="<?= htmlspecialchars($p['name']) ?>"
                          <?= ($old['product_interest'] ?? '') === $p['name'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($p['name']) ?> — $<?= number_format((float)$p['price_per_kg'],2) ?>/kg
                  </option>
                  <?php endforeach; ?>
                </optgroup>
                <optgroup label="☕ Freshly Roasted Beans">
                  <?php foreach (($products ?? []) as $p): if ($p['category'] !== 'roasted') continue; ?>
                  <option value="<?= htmlspecialchars($p['name']) ?>"
                          <?= ($old['product_interest'] ?? '') === $p['name'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($p['name']) ?> — $<?= number_format((float)$p['price_per_kg'],2) ?>/kg
                  </option>
                  <?php endforeach; ?>
                </optgroup>
                <option value="Custom sourcing request">Custom Sourcing Request</option>
                <option value="Multiple products (see message)">Multiple Products (describe below)</option>
              </select>
              <?php if (!empty($errors['product_interest'])): ?>
              <div style="color:var(--error);font-size:0.78rem;margin-top:0.3rem">
                <?= htmlspecialchars($errors['product_interest']) ?>
              </div>
              <?php endif; ?>
            </div>
          </div>
        </div>

        <!-- ─ Logistics ─ -->
        <div style="margin-bottom:2rem">
          <h2 style="font-size:1rem;font-weight:700;color:var(--espresso);margin-bottom:1.25rem;
                     padding-bottom:0.5rem;border-bottom:2px solid var(--cream)">
            🚢 Logistics Preferences
          </h2>
          <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
            <?php field('target_market',  'Target Market', 'text', $old, $errors, ['placeholder'=>'e.g. Germany, Netherlands']); ?>

            <!-- Incoterms -->
            <div>
              <label style="display:block;font-size:0.82rem;font-weight:600;color:var(--espresso);margin-bottom:0.4rem">
                Preferred Incoterms
              </label>
              <select name="delivery_terms"
                      style="width:100%;padding:0.65rem 1rem;border:1.5px solid var(--border);
                             border-radius:var(--radius);font-size:0.9rem;background:var(--white)">
                <?php foreach ($incoterms as $code => $label): ?>
                <option value="<?= $code ?>"
                        <?= (($old['delivery_terms'] ?? 'FOB') === $code) ? 'selected' : '' ?>>
                  <?= htmlspecialchars($label) ?>
                </option>
                <?php endforeach; ?>
              </select>
            </div>

            <?php field('incoterm_port', 'Destination Port', 'text', $old, $errors, ['placeholder'=>'e.g. Hamburg, Rotterdam']); ?>
          </div>
        </div>

        <!-- ─ Message ─ -->
        <div style="margin-bottom:2rem">
          <h2 style="font-size:1rem;font-weight:700;color:var(--espresso);margin-bottom:1.25rem;
                     padding-bottom:0.5rem;border-bottom:2px solid var(--cream)">
            💬 Additional Information
          </h2>
          <div>
            <label style="display:block;font-size:0.82rem;font-weight:600;color:var(--espresso);margin-bottom:0.4rem">
              Message / Specifications
            </label>
            <textarea name="message" rows="5"
                      placeholder="Tell us about your quality requirements, packaging preferences, target cup profile, existing blends, or any specific sourcing criteria..."
                      style="width:100%;padding:0.75rem 1rem;border:1.5px solid var(--border);
                             border-radius:var(--radius);font-size:0.9rem;resize:vertical"><?= htmlspecialchars($old['message'] ?? '') ?></textarea>
          </div>
        </div>

        <!-- Submit -->
        <div style="display:flex;align-items:center;gap:1.5rem;flex-wrap:wrap">
          <button type="submit" class="btn btn-primary btn-lg">
            📋 Submit Wholesale Inquiry
          </button>
          <p style="font-size:0.8rem;color:var(--text-muted)">
            By submitting, you agree to our privacy policy.<br>
            We never share your data with third parties.
          </p>
        </div>

      </form><!-- /form -->

      <!-- Sidebar info -->
      <aside>

        <div style="background:var(--espresso);border-radius:var(--radius-xl);padding:var(--space-6);
                    color:var(--white);margin-bottom:var(--space-5)">
          <div style="font-size:1.5rem;margin-bottom:0.75rem">📞</div>
          <h3 style="font-size:1rem;font-weight:700;margin-bottom:0.5rem">Direct Contact</h3>
          <p style="font-size:0.85rem;color:rgba(255,255,255,0.65);margin-bottom:1rem;line-height:1.6">
            For urgent inquiries or to speak directly with our B2B team:
          </p>
          <?php if (!empty($appConfig['contact']['whatsapp'])): ?>
          <a href="https://wa.me/<?= preg_replace('/\D/','', $appConfig['contact']['whatsapp']) ?>"
             class="btn btn-gold" style="width:100%;justify-content:center;margin-bottom:0.75rem"
             target="_blank" rel="noopener">
            💬 WhatsApp Business
          </a>
          <?php endif; ?>
          <?php if (!empty($appConfig['contact']['email'])): ?>
          <a href="mailto:<?= htmlspecialchars($appConfig['contact']['email']) ?>"
             style="display:block;text-align:center;font-size:0.875rem;color:rgba(255,255,255,0.6)">
            ✉️ <?= htmlspecialchars($appConfig['contact']['email']) ?>
          </a>
          <?php endif; ?>
        </div>

        <div style="background:var(--white);border-radius:var(--radius-xl);padding:var(--space-5);
                    border:1px solid var(--border-light)">
          <h3 style="font-size:0.95rem;font-weight:700;color:var(--espresso);margin-bottom:1rem">
            ✓ What to Expect
          </h3>
          <?php
          $steps = [
              ['01','Submission','Your inquiry is received and logged.'],
              ['02','Review','Our B2B team reviews your requirements (24h).'],
              ['03','Proposal','We send a customized pricing sheet.'],
              ['04','Samples','Free samples dispatched to qualified buyers.'],
              ['05','Agreement','Contract & logistics finalized.'],
          ];
          foreach ($steps as $step):
          ?>
          <div style="display:flex;gap:0.75rem;margin-bottom:0.75rem;align-items:flex-start">
            <span style="min-width:28px;height:28px;background:var(--forest);color:var(--white);
                         border-radius:50%;display:flex;align-items:center;justify-content:center;
                         font-size:0.7rem;font-weight:700;flex-shrink:0">
              <?= $step[0] ?>
            </span>
            <div>
              <div style="font-size:0.85rem;font-weight:600;color:var(--espresso)"><?= $step[1] ?></div>
              <div style="font-size:0.78rem;color:var(--text-muted)"><?= $step[2] ?></div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>

      </aside>

    </div><!-- /grid -->
    <?php endif; ?>

  </div>
</section>
