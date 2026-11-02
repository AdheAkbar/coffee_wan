<?php

/**
 * Inquiry Model
 * Coffee Export B2B
 */

namespace App\Models;

class Inquiry extends Model
{
    protected static string $table = 'inquiries';

    /**
     * Save a validated wholesale quote inquiry.
     */
    public function submitInquiry(array $data, string $ip, string $ua, string $referrer): int
    {
        return $this->create([
            'company_name'      => $data['company_name'],
            'company_website'   => $data['company_website']  ?? null,
            'company_country'   => $data['company_country'],
            'company_type'      => $data['company_type']     ?? 'other',
            'contact_name'      => $data['contact_name'],
            'contact_title'     => $data['contact_title']    ?? null,
            'email'             => $data['email'],
            'phone'             => $data['phone']             ?? null,
            'product_interest'  => $data['product_interest'],
            'category_interest' => $data['category_interest'] ?? 'green',
            'monthly_volume_kg' => $data['monthly_volume_kg'] ?? null,
            'target_market'     => $data['target_market']    ?? null,
            'delivery_terms'    => $data['delivery_terms']   ?? 'FOB',
            'incoterm_port'     => $data['incoterm_port']    ?? null,
            'message'           => $data['message']          ?? null,
            'status'            => 'new',
            'ip_address'        => $ip,
            'user_agent'        => substr($ua, 0, 255),
            'referrer'          => substr($referrer, 0, 255),
        ]);
    }

    /**
     * Validate inquiry form data. Returns array of error messages.
     */
    public static function validate(array $data): array
    {
        $errors = [];

        if (empty(trim($data['company_name'] ?? ''))) {
            $errors['company_name'] = 'Company name is required.';
        }

        if (empty(trim($data['company_country'] ?? ''))) {
            $errors['company_country'] = 'Country is required.';
        }

        if (empty(trim($data['contact_name'] ?? ''))) {
            $errors['contact_name'] = 'Contact name is required.';
        }

        if (empty(trim($data['email'] ?? '')) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'A valid business email address is required.';
        }

        if (empty(trim($data['product_interest'] ?? ''))) {
            $errors['product_interest'] = 'Please specify the product(s) you are interested in.';
        }

        return $errors;
    }
}
