<?php

/**
 * Application Routes
 * Coffee Export B2B
 *
 * $router is injected by App::run() before this file is included.
 * Syntax: $router->get('/uri', 'ControllerClass@method')
 *         $router->post('/uri', 'ControllerClass@method')
 */

// ─── Homepage ─────────────────────────────────────────────────────────────────
$router->get('/',         'HomeController@index');

// ─── Product Catalog ──────────────────────────────────────────────────────────
$router->get('/catalog',          'ProductController@index');
$router->get('/catalog/{slug}',   'ProductController@show');

// ─── API Endpoints (JSON) for dynamic catalog tab-switching ──────────────────
$router->get('/api/products',          'ProductController@apiIndex');
$router->get('/api/products/{slug}',   'ProductController@apiShow');
$router->get('/api/testimonials',      'TestimonialController@apiIndex');

// ─── Wholesale Inquiry ────────────────────────────────────────────────────────
$router->get('/inquiry',          'InquiryController@create');
$router->post('/inquiry',         'InquiryController@store');
$router->get('/inquiry/success',  'InquiryController@success');

// ─── About (static section, served from home for SPA-feel) ───────────────────
$router->get('/about',            'HomeController@about');
$router->get('/warehousing',      'HomeController@warehousing');
