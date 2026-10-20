<?php

declare(strict_types=1);

return [
    'paths' => ['api/*', 'cv'],
    'allowed_methods' => ['GET', 'HEAD', 'OPTIONS'],
    'allowed_origins' => array_filter(array_map(
        static fn (string $origin): string => trim($origin),
        explode(',', (string) env('FRONTEND_URL', 'http://localhost:4321'))
    )),
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],
    'exposed_headers' => ['ETag', 'Last-Modified'],
    'max_age' => 86400,
    'supports_credentials' => false,
];
