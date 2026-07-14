<?php
/**
 * App Configuration
 * Cấu hình chung cho ứng dụng
 */

return [
    'name' => $_ENV['APP_NAME'] ?? 'Game Top-up Portal',
    'env' => $_ENV['APP_ENV'] ?? 'development',
    'url' => $_ENV['APP_URL'] ?? 'http://localhost:8080',
    'debug' => ($_ENV['APP_DEBUG'] ?? 'true') === 'true',

    // Session
    'session' => [
        'name' => $_ENV['SESSION_NAME'] ?? 'game_topup_session',
        'lifetime' => (int)($_ENV['SESSION_LIFETIME'] ?? 3600),
    ],

    // MoMo
    'momo' => [
        'partner_code' => $_ENV['MOMO_PARTNER_CODE'] ?? 'MOMO',
        'access_key' => $_ENV['MOMO_ACCESS_KEY'] ?? 'F8BBA842ECF85',
        'secret_key' => $_ENV['MOMO_SECRET_KEY'] ?? 'K951B6PE1waDMi640xX08PD3vg6EkVlz',
        'api_endpoint' => $_ENV['MOMO_API_ENDPOINT'] ?? 'https://test-payment.momo.vn/v2/gateway/api',
        'redirect_url' => $_ENV['MOMO_REDIRECT_URL'] ?? 'http://localhost:8080/payment/callback',
        'ipn_url' => $_ENV['MOMO_IPN_URL'] ?? 'http://localhost:8080/payment/ipn',
    ],
];
