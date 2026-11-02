---
name: ui-ux-pro-max
description: >-
  Skill UI/UX Pro Max — Aktifkan skill ini ketika pengguna meminta perubahan
  tampilan, desain, layout, komponen, responsiveness, animasi, warna, tipografi,
  aksesibilitas, atau audit visual pada proyek. Skill ini memberikan panduan
  lengkap dan best practices untuk membangun UI/UX berkualitas tinggi pada
  proyek PHP MVC berbasis coffee_wan (AromaSource Global B2B).
---

# UI/UX Pro Max Skill

Skill ini adalah panduan lengkap untuk membangun, memperbaiki, dan mengaudit
UI/UX pada proyek **AromaSource Global — B2B Coffee Export** (PHP MVC,
pure CSS, vanilla JS).

---

## 🗂️ Struktur Asset UI

```
public/
├── css/
│   ├── app.css          ← Global: reset, variables, typography, layout, buttons, forms
│   ├── hero.css         ← Hero section & CTA
│   ├── catalog.css      ← Product catalog grid & cards
│   ├── warehouse.css    ← Warehousing/logistics section
│   └── testimonials.css ← Reviews & testimonials carousel
├── js/
│   ├── app.js           ← Navbar, mobile menu, scroll behavior
│   ├── catalog.js       ← Filter, search, sort products
│   └── carousel.js      ← Testimonials carousel
resources/views/
├── layouts/app.php      ← Master HTML layout (head, nav, footer)
├── partials/            ← navbar, footer, hero, catalog, warehouse, testimonials
└── pages/               ← home.php, catalog.php, inquiry.php
```

---

## 🎨 Design Token System

Selalu gunakan CSS custom properties ini, jangan hardcode warna:

```css
:root {
  /* Brand Colors */
  --espresso : #2C1A0E;  /* Primary: headings, nav background */
  --forest   : #2D5016;  /* CTA buttons, accents, links */
  --cream    : #F5F0E8;  /* Section backgrounds */
  --gold     : #C9A84C;  /* Highlights, stars, badges */

  /* Neutrals */
  --white    : #FFFFFF;
  --gray-100 : #F8F8F8;
  --gray-300 : #D1D5DB;
  --gray-500 : #6B7280;
  --gray-700 : #374151;
  --gray-900 : #111827;

  /* Typography */
  --font-sans : 'Inter', system-ui, sans-serif;

  /* Spacing scale (8px base) */
  --space-1  : 0.25rem;
  --space-2  : 0.5rem;
  --space-3  : 0.75rem;
  --space-4  : 1rem;
  --space-6  : 1.5rem;
  --space-8  : 2rem;
  --space-12 : 3rem;
  --space-16 : 4rem;

  /* Border radius */
  --radius-sm  : 4px;
  --radius-md  : 8px;
  --radius-lg  : 16px;
  --radius-full: 9999px;

  /* Shadows */
  --shadow-sm : 0 1px 3px rgba(0,0,0,.08);
  --shadow-md : 0 4px 12px rgba(0,0,0,.12);
  --shadow-lg : 0 8px 32px rgba(0,0,0,.16);

  /* Transitions */
  --transition      : 0.2s ease;
  --transition-slow : 0.4s ease;
}
```

---

## 📐 Responsive Breakpoints

Gunakan pendekatan **mobile-first**:

| Breakpoint | Min-width  | Kelas |
|------------|------------|-------|
| Mobile     | (default)  | —     |
| Tablet     | 640px      | sm    |
| Desktop    | 1024px     | lg    |
| Wide       | 1280px     | xl    |

```css
@media (min-width: 640px)  { /* sm  */ }
@media (min-width: 1024px) { /* lg  */ }
@media (min-width: 1280px) { /* xl  */ }
```

---

## 🧩 Komponen UI Standar

### Button
```css
.btn {
  display: inline-flex;
  align-items: center;
  gap: .5rem;
  padding: .75rem 1.5rem;
  border-radius: var(--radius-md);
  font-weight: 600;
  font-size: .9rem;
  cursor: pointer;
  transition: all var(--transition);
  text-decoration: none;
}
.btn-primary { background: var(--forest); color: var(--white); border: none; }
.btn-primary:hover { background: #1f3a0f; transform: translateY(-1px); box-shadow: var(--shadow-md); }
.btn-outline { background: transparent; color: var(--forest); border: 2px solid var(--forest); }
.btn-outline:hover { background: var(--forest); color: var(--white); }
```

### Card
```css
.card {
  background: var(--white);
  border-radius: var(--radius-lg);
  box-shadow: var(--shadow-sm);
  overflow: hidden;
  transition: transform var(--transition), box-shadow var(--transition);
}
.card:hover { transform: translateY(-4px); box-shadow: var(--shadow-md); }
```

### Badge
```css
.badge {
  display: inline-block;
  padding: .25rem .75rem;
  border-radius: var(--radius-full);
  font-size: .75rem;
  font-weight: 600;
  letter-spacing: .05em;
  text-transform: uppercase;
}
.badge-gold   { background: var(--gold);   color: var(--espresso); }
.badge-forest { background: var(--forest); color: var(--white); }
.badge-cream  { background: var(--cream);  color: var(--espresso); }
```

### Form Input
```css
.form-group { display: flex; flex-direction: column; gap: .5rem; margin-bottom: 1.25rem; }
.form-label { font-weight: 600; font-size: .9rem; color: var(--gray-700); }
.form-input, .form-select, .form-textarea {
  width: 100%;
  padding: .75rem 1rem;
  border: 1.5px solid var(--gray-300);
  border-radius: var(--radius-md);
  font-size: 1rem;
  font-family: var(--font-sans);
  transition: border-color var(--transition), box-shadow var(--transition);
  background: var(--white);
  color: var(--gray-900);
}
.form-input:focus, .form-select:focus, .form-textarea:focus {
  outline: none;
  border-color: var(--forest);
  box-shadow: 0 0 0 3px rgba(45,80,22,.15);
}
```

---

## ♿ Aksesibilitas (WCAG 2.1 AA)

Checklist wajib saat membuat atau memodifikasi komponen:

- [ ] Semua gambar punya `alt` yang deskriptif
- [ ] Kontras warna minimal 4.5:1 untuk teks normal, 3:1 untuk teks besar
- [ ] Semua form input punya `<label>` yang terhubung via `for`/`id`
- [ ] Interactive elements bisa diakses via keyboard (Tab, Enter, Space)
- [ ] Focus state terlihat jelas (jangan `outline:none` tanpa pengganti)
- [ ] ARIA attributes digunakan untuk komponen custom (modal, dropdown)
- [ ] Heading hierarchy benar: h1 > h2 > h3 (jangan skip level)
- [ ] Error form muncul inline dan terhubung ke input via `aria-describedby`

---

## 🚀 Performance UI

- Gunakan `loading="lazy"` pada semua `<img>` di bawah fold
- CSS animasi pakai `transform` dan `opacity` (hindari `width`/`height`/`top`)
- Gunakan `will-change: transform` hanya pada elemen yang sering dianimasikan
- Gambar produk: format WebP, ukuran max 800x800px

---

## 🔍 Audit UI/UX Checklist

### Visual Consistency
- [ ] Semua warna menggunakan CSS variables (bukan hardcode)
- [ ] Spacing mengikuti skala 8px
- [ ] Font weight konsisten (400 body, 600 subheading, 700 heading)
- [ ] Border radius konsisten per tipe elemen

### Responsiveness
- [ ] OK di mobile (320px-640px)
- [ ] OK di tablet (640px-1024px)
- [ ] OK di desktop (1024px+)
- [ ] Tidak ada horizontal scroll di layar manapun
- [ ] Touch target minimal 44x44px di mobile

### Interaksi & UX
- [ ] Hover state pada semua interactive elements
- [ ] Loading state pada form submit
- [ ] Empty state jika data kosong
- [ ] Error state yang informatif
- [ ] Feedback visual setelah aksi user

---

## 📋 Prosedur Kerja UI/UX

### Saat membuat komponen baru:
1. Tentukan lokasi: partial baru di `resources/views/partials/` atau inline di page
2. Buat HTML semantik dulu (tanpa style)
3. Tambahkan CSS di file yang relevan
4. Tambahkan interaksi JS di `app.js` atau file JS yang relevan
5. Uji di 3 breakpoint (mobile/tablet/desktop)
6. Jalankan accessibility checklist

### Saat memperbaiki UI/UX:
1. Identifikasi file CSS yang bermasalah berdasarkan section
2. Gunakan hanya design tokens, jangan hardcode nilai
3. Jangan hapus komentar yang sudah ada
4. Test di browser setelah perubahan

### Saat audit visual:
1. Buka semua halaman: `/`, `/catalog`, `/inquiry`
2. Periksa di DevTools: mobile 375px, tablet 768px, desktop 1440px
3. Cek console untuk error JS atau CSS 404
4. Jalankan checklist di atas

---

## 🔗 File Referensi Cepat

| Section         | View Partial                                 | CSS File                      |
|-----------------|----------------------------------------------|-------------------------------|
| Navbar          | resources/views/partials/navbar.php          | public/css/app.css            |
| Hero            | resources/views/partials/hero.php            | public/css/hero.css           |
| Product Catalog | resources/views/partials/catalog.php         | public/css/catalog.css        |
| Warehousing     | resources/views/partials/warehouse.php       | public/css/warehouse.css      |
| Testimonials    | resources/views/partials/testimonials.php    | public/css/testimonials.css   |
| Footer          | resources/views/partials/footer.php          | public/css/app.css            |
| Inquiry Form    | resources/views/pages/inquiry.php            | public/css/app.css            |
