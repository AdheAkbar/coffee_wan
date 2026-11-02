<?php

/**
 * InquiryController
 * Coffee Export B2B
 *
 * Handles wholesale quote request form (GET/POST) and success page.
 */

namespace App\Controllers;

use Core\Controller;
use Core\Request;
use App\Models\Inquiry;
use App\Models\Product;

class InquiryController extends Controller
{
    /**
     * GET /inquiry — Display the wholesale quote request form.
     */
    public function create(Request $request, array $params = []): void
    {
        $products = (new Product())->getActive();

        $this->render('pages.inquiry', [
            'pageTitle'       => 'Request Wholesale Quote | AromaSource Global',
            'metaDescription' => 'Submit a wholesale coffee inquiry. We respond to all B2B requests within 24 business hours.',
            'products'        => array_map([Product::class, 'sanitize'], $products),
            'errors'          => [],
            'old'             => [],
            'activeNav'       => 'inquiry',
        ]);
    }

    /**
     * POST /inquiry — Process the submitted form.
     */
    public function store(Request $request, array $params = []): void
    {
        // Collect and strip tags from all inputs
        $data = [
            'company_name'      => strip_tags($request->input('company_name',     '')),
            'company_website'   => strip_tags($request->input('company_website',  '')),
            'company_country'   => strip_tags($request->input('company_country',  '')),
            'company_type'      => strip_tags($request->input('company_type',     'other')),
            'contact_name'      => strip_tags($request->input('contact_name',     '')),
            'contact_title'     => strip_tags($request->input('contact_title',    '')),
            'email'             => strip_tags($request->input('email',            '')),
            'phone'             => strip_tags($request->input('phone',            '')),
            'product_interest'  => strip_tags($request->input('product_interest', '')),
            'category_interest' => strip_tags($request->input('category_interest','green')),
            'monthly_volume_kg' => (int) $request->input('monthly_volume_kg',    0),
            'target_market'     => strip_tags($request->input('target_market',    '')),
            'delivery_terms'    => strip_tags($request->input('delivery_terms',   'FOB')),
            'incoterm_port'     => strip_tags($request->input('incoterm_port',    '')),
            'message'           => strip_tags($request->input('message',          '')),
        ];

        // Validate
        $errors = Inquiry::validate($data);

        if (!empty($errors)) {
            // Re-render form with errors and old input
            $products = (new Product())->getActive();
            $this->render('pages.inquiry', [
                'pageTitle' => 'Request Wholesale Quote | AromaSource Global',
                'products'  => array_map([Product::class, 'sanitize'], $products),
                'errors'    => $errors,
                'old'       => $data,
                'activeNav' => 'inquiry',
            ]);
            return;
        }

        // Persist to database
        $inquiry = new Inquiry();
        $id = $inquiry->submitInquiry(
            $data,
            $_SERVER['REMOTE_ADDR']      ?? '0.0.0.0',
            $_SERVER['HTTP_USER_AGENT']  ?? '',
            $_SERVER['HTTP_REFERER']     ?? ''
        );

        // Redirect to success page
        $this->redirect('/inquiry/success?ref=' . $id);
    }

    /**
     * GET /inquiry/success — Confirmation page after submission.
     */
    public function success(Request $request, array $params = []): void
    {
        $this->render('pages.inquiry', [
            'pageTitle'  => 'Inquiry Received | AromaSource Global',
            'submitted'  => true,
            'refId'      => $request->query('ref', ''),
            'activeNav'  => 'inquiry',
        ]);
    }
}
