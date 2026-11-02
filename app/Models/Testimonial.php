<?php

/**
 * Testimonial Model
 * Coffee Export B2B
 */

namespace App\Models;

class Testimonial extends Model
{
    protected static string $table = 'testimonials';

    /**
     * All active testimonials ordered by sort_order.
     */
    public function getActive(int $limit = 0): array
    {
        return $this->where(['active' => 1], 'sort_order ASC, id ASC', $limit);
    }

    /**
     * Testimonials for the homepage carousel (top N).
     */
    public function getForCarousel(int $limit = 6): array
    {
        return $this->getActive($limit);
    }

    /**
     * Sanitize testimonial data for safe HTML output.
     */
    public static function sanitize(array $t): array
    {
        $fields = ['client_name','client_title','company_name','company_country',
                   'quote','company_logo_path','volume_per_year'];

        foreach ($fields as $field) {
            if (isset($t[$field])) {
                $t[$field] = htmlspecialchars($t[$field], ENT_QUOTES, 'UTF-8');
            }
        }

        return $t;
    }

    /**
     * Generate star HTML for a given rating.
     */
    public static function starsHtml(int $rating): string
    {
        $rating = max(1, min(5, $rating));
        $stars  = str_repeat('<span class="star filled">★</span>', $rating)
                . str_repeat('<span class="star empty">☆</span>', 5 - $rating);
        return '<span class="stars">' . $stars . '</span>';
    }
}
