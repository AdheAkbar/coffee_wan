# AromaSource Global — B2B Coffee Export Website

A complete, dynamic B2B corporate website for a premium coffee export company, built with a pure PHP MVC architecture.

---

## 🚀 Quick Start (3 Steps)

### Step 1 — Set Up Database
```sql
-- In MySQL Workbench or phpMyAdmin, run these in order:
SOURCE database/migrations/001_create_products_table.sql;
SOURCE database/migrations/002_create_testimonials_table.sql;
SOURCE database/migrations/003_create_inquiries_table.sql;
SOURCE database/migrations/004_seed_data.sql;
```

### Step 2 — Configure Database Credentials
Edit `config/database.php`:
```php
'database' => 'coffee_export_b2b',
'username' => 'your_mysql_user',
'password' => 'your_mysql_password',
```

### Step 3 — Start the Server

**Option A — PHP Built-in Server (recommended for dev):**
```bash
php -S localhost:8080 -t public
# Open: http://localhost:8080
```

**Option B — XAMPP / WAMP / Laragon:**
- Place the `coffee_wan/` folder in `htdocs/`
- Update `config/app.php` → `'url' => 'http://localhost/coffee_wan/public'`
- Open: `http://localhost/coffee_wan/public/`

**Option C — Nginx:**
```nginx
root /path/to/coffee_wan/public;
index index.php;
location / {
    try_files $uri $uri/ /index.php?$query_string;
}
location ~ \.php$ {
    fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
    include fastcgi_params;
    fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
}
```

---

## 📁 Project Structure

```
coffee_wan/
├── app/
│   ├── Controllers/          ← HomeController, ProductController,
│   │                           TestimonialController, InquiryController
│   └── Models/               ← Product, Testimonial, Inquiry (+ base Model)
├── config/
│   ├── app.php               ← Company name, contact, certifications, stats
│   └── database.php          ← MySQL connection credentials
├── core/                     ← Custom MVC framework (App, Router, Controller,
│                               Database, Request)
├── database/
│   └── migrations/           ← 4 SQL files (schema + seed data)
├── public/                   ← Document root
│   ├── index.php             ← Front controller
│   ├── .htaccess             ← Apache URL rewriting
│   ├── css/                  ← app, hero, catalog, warehouse, testimonials
│   └── js/                   ← app, catalog, carousel
├── resources/
│   └── views/
│       ├── layouts/app.php   ← Master HTML layout
│       ├── partials/         ← navbar, footer, hero, catalog, warehouse, testimonials
│       └── pages/            ← home, catalog, inquiry
└── routes/
    └── web.php               ← All route definitions
```

---

## 🌐 Routes

| Method | Route              | Handler                          |
|--------|--------------------|----------------------------------|
| GET    | `/`                | `HomeController@index`           |
| GET    | `/catalog`         | `ProductController@index`        |
| GET    | `/catalog/{slug}`  | `ProductController@show`         |
| GET    | `/inquiry`         | `InquiryController@create`       |
| POST   | `/inquiry`         | `InquiryController@store`        |
| GET    | `/inquiry/success` | `InquiryController@success`      |
| GET    | `/api/products`    | `ProductController@apiIndex`     |
| GET    | `/api/testimonials`| `TestimonialController@apiIndex` |

---

## 🎨 Design System

| Token        | Value       | Usage                    |
|--------------|-------------|--------------------------|
| `--espresso` | `#2C1A0E`   | Primary brand, headings  |
| `--forest`   | `#2D5016`   | CTAs, accents            |
| `--cream`    | `#F5F0E8`   | Section backgrounds      |
| `--gold`     | `#C9A84C`   | Highlights, star ratings |

---

## 🔧 Customization

- **Company info** → `config/app.php`
- **Add products** → Run SQL `INSERT` into `products` table
- **Add testimonials** → Run SQL `INSERT` into `testimonials` table  
- **Styling** → `public/css/app.css` (CSS custom properties at top)
- **Real images** → Replace placeholder paths in `products.image_path` column, store files in `public/images/products/`

---

## 📋 Requirements

- PHP 8.1+
- MySQL 5.7+ / MariaDB 10.4+
- Apache (mod_rewrite enabled) or Nginx or PHP built-in server
