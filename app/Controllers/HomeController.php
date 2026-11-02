<?php

/**
 * HomeController
 * Coffee Export B2B
 *
 * Handles the homepage, about page, and warehousing page.
 */

namespace App\Controllers;

use Core\Controller;
use Core\Request;
use App\Models\Product;
use App\Models\Testimonial;

class HomeController extends Controller
{
    /**
     * GET / — Homepage
     * Assembles all homepage section data and renders the home view.
     */
    public function index(Request $request, array $params = []): void
    {
        $productModel      = new Product();
        $testimonialModel  = new Testimonial();

        $greenBeans   = $productModel->getGreenBeans();
        $roastedBeans = $productModel->getRoastedBeans();
        $featured     = $productModel->getFeatured(6);
        $testimonials = $testimonialModel->getForCarousel(6);

        // Sanitize for safe output
        $greenBeans   = array_map([Product::class,      'sanitize'], $greenBeans);
        $roastedBeans = array_map([Product::class,      'sanitize'], $roastedBeans);
        $featured     = array_map([Product::class,      'sanitize'], $featured);
        $testimonials = array_map([Testimonial::class,  'sanitize'], $testimonials);

        $warehouseImages = $this->getWarehouseImages();

        $this->render('pages.home', [
            'pageTitle'       => 'Premium Coffee Export | AromaSource Global',
            'metaDescription' => 'B2B wholesale coffee export — premium green beans and freshly roasted coffee from Indonesia and East Africa. ISO 22000 certified. Request your wholesale quote today.',
            'greenBeans'      => $greenBeans,
            'roastedBeans'    => $roastedBeans,
            'featured'        => $featured,
            'testimonials'    => $testimonials,
            'warehouseImages' => $warehouseImages,
            'activeNav'       => 'home',
        ]);
    }

    /**
     * GET /about — Static about page
     */
    public function about(Request $request, array $params = []): void
    {
        $this->render('pages.home', [
            'pageTitle'  => 'About AromaSource Global',
            'activeNav'  => 'about',
            'scrollTo'   => 'about',
        ]);
    }

    /**
     * GET /warehousing — Warehousing page
     */
    public function warehousing(Request $request, array $params = []): void
    {
        $this->render('pages.home', [
            'pageTitle'  => 'Climate-Controlled Coffee Warehousing | AromaSource',
            'activeNav'  => 'warehousing',
            'scrollTo'   => 'warehousing',
        ]);
    }

    /**
     * Build the warehouse images data array.
     * In production, these would be loaded from a CMS or database.
     */
    private function getWarehouseImages(): array
    {
        return [
            [
                'title'       => 'Climate-Controlled Storage Silos',
                'description' => 'Temperature maintained at 18–22°C with ±1°C variance. Individual bay monitoring for 500+ MT capacity.',
                'icon'        => '🌡️',
                'spec'        => '18–22°C | ±1°C precision',
                'css_theme'   => 'silo',
            ],
            [
                'title'       => 'Humidity Regulation System',
                'description' => 'Automated dehumidification maintains 60–65% RH to prevent moisture absorption and mold development.',
                'icon'        => '💧',
                'spec'        => '60–65% RH | Automated',
                'css_theme'   => 'humidity',
            ],
            [
                'title'       => 'GrainPro Cocoon Storage',
                'description' => 'Hermetic storage bags preserve green bean freshness for up to 12 months without quality degradation.',
                'icon'        => '🛡️',
                'spec'        => '12-Month Freshness | Hermetic',
                'css_theme'   => 'hermetic',
            ],
            [
                'title'       => 'Robotic Sorting & Grading Line',
                'description' => 'NIR optical sorting machinery inspects 3 MT/hour, eliminating defective beans to Grade 1 standards.',
                'icon'        => '⚙️',
                'spec'        => '3 MT/hr | NIR Optical',
                'css_theme'   => 'sorting',
            ],
            [
                'title'       => 'Export Loading Bay',
                'description' => 'ISO-certified container stuffing facility with 24/7 security, CCTV, and real-time shipment tracking.',
                'icon'        => '🚢',
                'spec'        => '24/7 Operations | ISO Certified',
                'css_theme'   => 'loading',
            ],
            [
                'title'       => 'Quality Control Laboratory',
                'description' => 'On-site cupping lab staffed by Q-Grader certified professionals. Every lot cupped before export approval.',
                'icon'        => '🔬',
                'spec'        => 'Q-Grader Certified | Every Lot',
                'css_theme'   => 'lab',
            ],
        ];
    }
}
