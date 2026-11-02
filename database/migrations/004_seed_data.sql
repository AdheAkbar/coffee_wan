-- =============================================================
--  Migration 004 — Seed Data
--  Coffee Export B2B — Sample Products & Testimonials
-- =============================================================

USE coffee_export_b2b;

-- ─────────────────────────────────────────────────────────────
--  PRODUCTS — Premium Green Beans
-- ─────────────────────────────────────────────────────────────
INSERT INTO products
  (name, slug, category, origin, region, altitude_masl, process, harvest_period,
   grade, screen_size, moisture_pct, defect_count, flavor_notes, cupping_score,
   description, price_per_kg, moq_kg, lead_days, badge, featured)
VALUES

('Sumatra Mandheling G1',
 'sumatra-mandheling-g1', 'green',
 'Sumatra Mandheling', 'North Sumatra', 1200, 'wet-hulled', 'April – June',
 'Grade 1 Specialty', '17/18', 12.5, 8,
 'Dark chocolate, cedar, earthy, low acidity, full body',
 86.5,
 'Grown in the volcanic highlands of North Sumatra, our Mandheling Green Beans undergo traditional wet-hulling (Giling Basah) producing the signature earthy complexity and syrupy body prized by roasters worldwide.',
 7.20, 500, 14, 'Best Seller', 1),

('Ethiopia Yirgacheffe Washed',
 'ethiopia-yirgacheffe-washed', 'green',
 'Ethiopia Yirgacheffe', 'SNNPR', 1800, 'washed', 'November – January',
 'Grade 1 Specialty', '15/16', 11.8, 5,
 'Jasmine, bergamot, lemon zest, bright acidity, tea-like body',
 90.0,
 'The gold standard of African specialty coffee. These meticulously hand-sorted Yirgacheffe beans deliver extraordinary florality and citric brightness that commands premium pricing in specialty markets globally.',
 9.80, 300, 14, 'Specialty', 1),

('Java Preanger Natural',
 'java-preanger-natural', 'green',
 'Java Preanger', 'West Java', 1500, 'natural', 'July – September',
 'Grade 1 Specialty', '16/17', 12.0, 6,
 'Blueberry, dark cherry, wine, medium body, lingering sweetness',
 87.5,
 'Sun-dried on raised African beds at 1,500 masl in West Java''s Preanger highlands. The extended drying period develops intense fruit-forward complexity with wine-like fermented notes.',
 8.50, 300, 21, 'Organic', 1),

('Flores Bajawa G2',
 'flores-bajawa-g2', 'green',
 'Flores Bajawa', 'East Nusa Tenggara', 1000, 'washed', 'May – July',
 'Grade 2 Commercial', '15/16', 13.0, 12,
 'Brown sugar, tobacco, mild spice, balanced acidity',
 83.0,
 'A dependable commercial-grade green bean from the volcanic island of Flores. Consistent quality across large export lots makes it ideal for commercial espresso blends and RTD coffee manufacturing.',
 5.90, 1000, 10, NULL, 0),

('Toraja Sapan Honey',
 'toraja-sapan-honey', 'green',
 'Toraja Sapan', 'South Sulawesi', 1600, 'honey', 'June – August',
 'Grade 1 Specialty', '17/18', 11.5, 4,
 'Peach, apricot, caramel, silky mouthfeel, gentle brightness',
 88.5,
 'Honey-processed at family-run washing stations in the Toraja highlands. Partial mucilage retention creates a naturally sweet, fruit-forward cup profile without the risk of fermentation defects.',
 10.50, 200, 21, 'New', 0),

('Papua Wamena Organic',
 'papua-wamena-organic', 'green',
 'Papua Wamena', 'Papua', 1700, 'washed', 'March – May',
 'Grade 1 Organic', '17/18', 11.2, 3,
 'Citrus peel, clove, dark chocolate, very clean, bright',
 89.0,
 'Grown without synthetic inputs in the isolated Baliem Valley of Papua. USDA Organic certified. Extremely limited annual supply — ideal for premium single-origin positioning.',
 12.00, 100, 28, 'Organic', 0);

-- ─────────────────────────────────────────────────────────────
--  PRODUCTS — Freshly Roasted Beans
-- ─────────────────────────────────────────────────────────────
INSERT INTO products
  (name, slug, category, origin, process, roast_level, roast_profile,
   flavor_notes, cupping_score, description,
   price_per_kg, moq_kg, lead_days, badge, featured)
VALUES

('AromaSource Espresso Blend',
 'aromasource-espresso-blend', 'roasted',
 'Indonesia & Ethiopia Blend', 'washed',
 'medium-dark', 'Developed roast — 9:30 min, 205°C drop',
 'Dark chocolate, caramel, hazelnut, full crema',
 85.5,
 'Our house espresso blend combines the body of Sumatra Mandheling with the brightness of Ethiopian Yirgacheffe. Developed over three years for European specialty café chains. Available roasted-to-order with 48-hour dispatch.',
 18.50, 100, 3, 'Best Seller', 1),

('Sumatra Mandheling Medium Roast',
 'sumatra-mandheling-medium-roast', 'roasted',
 'Sumatra Mandheling', 'wet-hulled',
 'medium', 'City roast — 8:45 min, 200°C drop',
 'Milk chocolate, cedar, walnut, low acidity',
 85.0,
 'Single-origin medium roast that preserves the earthy terroir of Mandheling while unlocking sweetness. Popular for filter programs and premium RTD lines. Roasted weekly in 500kg batches.',
 19.00, 50, 3, NULL, 1),

('Ethiopia Natural Light Roast',
 'ethiopia-natural-light-roast', 'roasted',
 'Ethiopia Yirgacheffe Natural', 'natural',
 'light', 'Scandinavian profile — 8:00 min, 194°C drop',
 'Strawberry, hibiscus, tropical fruit, wine, extremely bright',
 90.5,
 'Light roasted to preserve maximum origin character. Extremely popular in the Scandinavian and Japanese specialty markets. Cupping score 90+. Ships in nitrogen-flushed valve bags.',
 24.00, 25, 5, 'Specialty', 1),

('Bali Kintamani Dark Roast',
 'bali-kintamani-dark-roast', 'roasted',
 'Bali Kintamani', 'natural',
 'dark', 'Full city+ roast — 10:00 min, 212°C drop',
 'Bittersweet dark chocolate, brown sugar, smoky finish',
 82.0,
 'A bold, full-city dark roast from the volcanic caldera of Kintamani, Bali. Ideal for hotel chains, airline catering, and institutional buyers seeking a consistent bold cup.',
 16.80, 50, 3, NULL, 0),

('Flores Honey Medium-Dark Roast',
 'flores-honey-medium-dark', 'roasted',
 'Flores Bajawa', 'honey',
 'medium-dark', 'Vienna roast — 9:45 min, 208°C drop',
 'Dried stone fruit, toffee, mild smoke, round body',
 84.0,
 'Honey-processed Flores elevated through a Vienna roast profile. Excellent for white-label wholesale programs. Available with custom packaging and private label branding.',
 20.50, 50, 7, 'New', 0);

-- ─────────────────────────────────────────────────────────────
--  TESTIMONIALS — B2B Client Reviews
-- ─────────────────────────────────────────────────────────────
INSERT INTO testimonials
  (client_name, client_title, company_name, company_country,
   quote, rating, partnership_since, volume_per_year, sort_order)
VALUES

('Thomas Müller',
 'Head of Green Coffee Procurement',
 'Röstwerk Hamburg GmbH',
 'Germany',
 'AromaSource has been our primary Indonesian supplier for six years. Their Sumatra Mandheling G1 is the backbone of our flagship espresso blend. Quality consistency across 40MT annual lots is exceptional — we''ve never had a shipment fail our in-house QC lab.',
 5, 2018, '40 MT/year', 1),

('Sofia Andersson',
 'Co-Founder & Head Buyer',
 'Nordic Brew Partners AB',
 'Sweden',
 'As a specialty importer serving 120+ independent cafes across Scandinavia, green bean consistency is non-negotiable. AromaSource''s Ethiopia Yirgacheffe lots have scored 89–91 on our cuppings for three consecutive years. The traceability documentation is world-class.',
 5, 2020, '18 MT/year', 2),

('James Okafor',
 'Director of Supply Chain',
 'PanAfrica Coffee Distributors',
 'United Kingdom',
 'We approached AromaSource when scaling our roasted-to-order wholesale program. Their roasting facility''s capacity and the 48-hour turnaround on the Espresso Blend was a game changer. The commercial team is transparent, responsive, and truly understands B2B supply dynamics.',
 5, 2021, '25 MT/year', 3),

('Yuki Tanaka',
 'Purchasing Manager',
 'Kyoto Artisan Roastery K.K.',
 'Japan',
 'Indonesian and natural-processed Ethiopian coffees are the foundation of our Japanese café brand. AromaSource''s natural Java Preanger is unlike anything we''ve sourced from other exporters — the blueberry and wine complexity is unmatched. Excellent producer relationship transparency.',
 5, 2019, '12 MT/year', 4),

('Carlos Mendoza',
 'VP Procurement',
 'LatinBean Importadores S.A.',
 'Mexico',
 'Competitive FOB pricing, ISO-certified warehousing, and professional phytosanitary documentation have made AromaSource our go-to Indonesian origin partner. Lead time commitments are always honoured. Strong recommend for any importer scaling their Sumatra or Java programs.',
 4, 2022, '30 MT/year', 5),

('Priya Sharma',
 'Chief Operating Officer',
 'IndiaRoast Private Ltd.',
 'India',
 'After testing samples from eight Indonesian exporters, AromaSource''s Papua Wamena Organic was the clear winner on cup quality and certification integrity. We''ve since expanded to three SKUs. Their documentation support for Indian import compliance is thorough and proactive.',
 5, 2023, '8 MT/year', 6);
