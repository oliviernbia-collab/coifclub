<?php

return [
    'stripe_secret' => env('STRIPE_SECRET'),

    'paypal_client_id' => env('PAYPAL_CLIENT_ID'),
    'paypal_secret' => env('PAYPAL_SECRET'),
    'paypal_mode' => env('PAYPAL_MODE', 'sandbox'),
    'paypal_currency' => env('PAYPAL_CURRENCY', 'EUR'),
    'paypal_conversion_rate' => env('PAYPAL_CONVERSION_RATE', 0.0015),
    'paypal_base_url' => env('PAYPAL_MODE', 'sandbox') === 'live'
        ? 'https://api-m.paypal.com'
        : 'https://api-m.sandbox.paypal.com',

    'cinetpay_url' => env('CINETPAY_URL', 'https://api-checkout.cinetpay.com/v2'),
    'cinetpay_key' => env('CINETPAY_KEY'),
    'cinetpay_site_id' => env('CINETPAY_SITE_ID'),
];
