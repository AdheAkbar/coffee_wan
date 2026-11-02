<?php

/**
 * TestimonialController
 * Coffee Export B2B
 */

namespace App\Controllers;

use Core\Controller;
use Core\Request;
use App\Models\Testimonial;

class TestimonialController extends Controller
{
    /**
     * GET /api/testimonials
     * Returns active testimonials as JSON for the carousel.
     */
    public function apiIndex(Request $request, array $params = []): void
    {
        $model        = new Testimonial();
        $testimonials = $model->getForCarousel();
        $testimonials = array_map([Testimonial::class, 'sanitize'], $testimonials);

        // Add computed fields
        foreach ($testimonials as &$t) {
            $t['stars_html']       = Testimonial::starsHtml((int) $t['rating']);
            $t['initials']         = $this->getInitials($t['company_name']);
        }
        unset($t);

        $this->json([
            'success' => true,
            'count'   => count($testimonials),
            'data'    => $testimonials,
        ]);
    }

    /**
     * Generate 2-letter initials from a company name for logo fallback.
     */
    private function getInitials(string $name): string
    {
        $words = array_filter(explode(' ', $name));
        if (count($words) >= 2) {
            return strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
        }
        return strtoupper(substr($name, 0, 2));
    }
}
