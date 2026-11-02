<?php

/**
 * Product Model
 * Coffee Export B2B
 */

namespace App\Models;

class Product extends Model
{
    protected static string $table = 'products';

    // ─── Scoped Queries ──────────────────────────────────────────────

    /**
     * All active products, optionally filtered by category.
     */
    public function getActive(?string $category = null, int $limit = 0): array
    {
        if ($category) {
            return $this->where(
                ['active' => 1, 'category' => $category],
                'featured DESC, name ASC',
                $limit
            );
        }

        return $this->where(['active' => 1], 'category ASC, featured DESC, name ASC', $limit);
    }

    /**
     * Featured products for the homepage hero catalog preview.
     */
    public function getFeatured(int $limit = 6): array
    {
        return $this->where(['active' => 1, 'featured' => 1], 'category ASC, name ASC', $limit);
    }

    /**
     * Find a product by URL slug.
     */
    public function findBySlug(string $slug): ?array
    {
        return $this->first(['slug' => $slug, 'active' => 1]);
    }

    /**
     * Get all active green bean products.
     */
    public function getGreenBeans(int $limit = 0): array
    {
        return $this->getActive('green', $limit);
    }

    /**
     * Get all active roasted bean products.
     */
    public function getRoastedBeans(int $limit = 0): array
    {
        return $this->getActive('roasted', $limit);
    }

    /**
     * Return product counts grouped by category.
     */
    public function countByCategory(): array
    {
        $stmt = $this->db->query(
            "SELECT category, COUNT(*) AS total
             FROM " . static::$table . "
             WHERE active = 1
             GROUP BY category"
        );
        $rows = $stmt->fetchAll();

        $result = ['green' => 0, 'roasted' => 0];
        foreach ($rows as $row) {
            $result[$row['category']] = (int) $row['total'];
        }
        return $result;
    }

    /**
     * Sanitize a product array for safe output in views.
     */
    public static function sanitize(array $product): array
    {
        $stringFields = ['name','slug','category','origin','region','process',
                         'grade','screen_size','flavor_notes','description',
                         'roast_level','roast_profile','image_path','badge','currency'];

        foreach ($stringFields as $field) {
            if (isset($product[$field])) {
                $product[$field] = htmlspecialchars($product[$field], ENT_QUOTES, 'UTF-8');
            }
        }

        return $product;
    }
}
