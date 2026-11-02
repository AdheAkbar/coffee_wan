<?php

/**
 * ╔═══════════════════════════════════════════════════════════╗
 * ║  AromaSource Global — B2B Coffee Export Website          ║
 * ║  Front Controller / Application Entry Point              ║
 * ║                                                          ║
 * ║  All HTTP requests are routed through this file          ║
 * ║  via Apache (.htaccess) or Nginx rewrite rules.          ║
 * ╚═══════════════════════════════════════════════════════════╝
 *
 * Usage (local development, PHP built-in server):
 *   php -S localhost:8080 -t public
 *
 * Usage (Apache/XAMPP):
 *   Point DocumentRoot to /path/to/coffee-export-b2b/public
 *   Or place project in htdocs and access at:
 *   http://localhost/coffee_wan/public/
 *
 * Usage (Nginx):
 *   root /path/to/coffee-export-b2b/public;
 *   try_files $uri $uri/ /index.php?$query_string;
 */

declare(strict_types=1);

// ─── Root path constant ──────────────────────────────────────────────────────
define('ROOT_PATH', dirname(__DIR__));

// ─── Load application bootstrap ─────────────────────────────────────────────
require_once ROOT_PATH . '/core/App.php';

// ─── Bootstrap and run ──────────────────────────────────────────────────────
(new \Core\App())->run();
