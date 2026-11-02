<?php

/**
 * ProductController
 * Coffee Export B2B
 *
 * Handles the product catalog page, product detail, and JSON API endpoints.
 */

namespace App\Controllers;

use Core\Controller;
use Core\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * GET /catalog — Full catalog page with tab-based category filter.
     */
    public function index(Request $request, array $params = []): void
    {
        $model = new Product();

        $activeTab    = in_array($request->query('tab'), ['green', 'roasted'])
                        ? $request->query('tab')
                        : 'green';

        $greenBeans   = array_map([Product::class, 'sanitize'], $model->getGreenBeans());
        $roastedBeans = array_map([Product::class, 'sanitize'], $model->getRoastedBeans());
        $counts       = $model->countByCategory();

        $this->render('pages.catalog', [
            'pageTitle'     => 'Product Catalog — Premium Green & Roasted Coffee | AromaSource',
            'metaDescription' => 'Browse our wholesale catalog of premium Indonesian and African green coffee beans and freshly roasted coffees. Full technical specs, pricing, and MOQs.',
            'greenBeans'    => $greenBeans,
            'roastedBeans'  => $roastedBeans,
            'counts'        => $counts,
            'activeTab'     => $activeTab,
            'activeNav'     => 'catalog',
        ]);
    }

    /**
     * GET /catalog/{slug} — Product detail page.
     */
    public function show(Request $request, array $params = []): void
    {
        $model   = new Product();
        $product = $model->findBySlug($params['slug'] ?? '');

        if (!$product) {
            http_response_code(404);
            $this->render('pages.catalog', [
                'pageTitle' => 'Product Not Found',
                'error'     => 'The requested product could not be found.',
            ]);
            return;
        }

        $product  = Product::sanitize($product);
        $related  = array_map(
            [Product::class, 'sanitize'],
            $model->getActive($product['category'], 3)
        );
        // Exclude current product from related
        $related  = array_filter($related, fn($p) => $p['id'] !== $product['id']);
        $related  = array_slice(array_values($related), 0, 3);

        $this->render('pages.catalog', [
            'pageTitle'   => $product['name'] . ' — Wholesale Coffee | AromaSource',
            'product'     => $product,
            'related'     => $related,
            'view'        => 'detail',
            'activeNav'   => 'catalog',
        ]);
    }

    // ─── JSON API Endpoints ───────────────────────────────────────────

    /**
     * GET /api/products?category=green|roasted
     * Returns active products as JSON for dynamic frontend filtering.
     */
    public function apiIndex(Request $request, array $params = []): void
    {
        $model    = new Product();
        $category = $request->query('category');

        if ($category && in_array($category, ['green', 'roasted'])) {
            $products = $model->getActive($category);
        } else {
            $products = $model->getActive();
        }

        $products = array_map([Product::class, 'sanitize'], $products);

        $this->json([
            'success'  => true,
            'count'    => count($products),
            'category' => $category ?? 'all',
            'data'     => $products,
        ]);
    }

    /**
     * GET /api/products/{slug}
     * Returns a single product as JSON.
     */
    public function apiShow(Request $request, array $params = []): void
    {
        $model   = new Product();
        $product = $model->findBySlug($params['slug'] ?? '');

        if (!$product) {
            $this->json(['success' => false, 'message' => 'Product not found.'], 404);
            return;
        }

        $this->json(['success' => true, 'data' => Product::sanitize($product)]);
    }
}
