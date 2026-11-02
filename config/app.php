<?php

/**
 * Application Configuration
 * Coffee Export B2B — Core App Settings
 */

return [
    'name'    => 'AromaSource Global',
    'tagline' => 'Premium Coffee Export, Delivered Wholesale',
    'url'     => 'http://localhost/coffee_wan/public',
    'env'     => 'development', // 'production' | 'development'
    'debug'   => true,

    'contact' => [
        'email'   => 'wholesale@aromasource.com',
        'phone'   => '+62 21 5000 7890',
        'address' => 'Jl. Kopi Nusantara No. 12, Jakarta Selatan, Indonesia 12345',
        'whatsapp'=> '+6281234567890',
    ],

    'social' => [
        'linkedin'  => '#',
        'instagram' => '#',
        'twitter'   => '#',
    ],

    'certifications' => [
        'ISO 22000:2018',
        'UTZ Certified',
        'Rainforest Alliance',
        'Fair Trade USA',
        'USDA Organic',
    ],

    'stats' => [
        ['value' => '15+',  'label' => 'Years of Excellence'],
        ['value' => '40+',  'label' => 'Export Destinations'],
        ['value' => '500+', 'label' => 'Wholesale Partners'],
        ['value' => '99.8%','label' => 'Quality Pass Rate'],
    ],
];
