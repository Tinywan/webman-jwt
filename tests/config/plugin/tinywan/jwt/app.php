<?php

declare(strict_types=1);

return [
    'enable' => true,
    'jwt' => [
        'algorithms' => 'HS256',
        'access_secret_key' => 'test-access-secret-key-0000000000000000000000000000000000000000',
        'access_exp' => 7200,
        'refresh_secret_key' => 'test-refresh-secret-key-000000000000000000000000000000000000000',
        'refresh_exp' => 604800,
        'refresh_disable' => false,
        'iss' => 'webman-jwt.test',
        'nbf' => 0,
        'leeway' => 60,
        'is_single_device' => false,
        'cache_token_ttl' => 604800,
        'cache_token_pre' => 'JWT:TOKEN:',
        'cache_refresh_token_pre' => 'JWT:REFRESH_TOKEN:',
        'user_model' => static function ($uid): array {
            return ['id' => $uid];
        },
        'is_support_get_token' => false,
        'is_support_get_token_key' => 'authorization',
    ],
];
