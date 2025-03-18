<?php

return [
    'quality' => env('ORCHID_WEBP_QUALITY', 100),
    'cache' => [
        'ttl' => env('ORCHID_WEBP_CACHE_TTL'),
        'key' => env('ORCHID_WEBP_CACHE_KEY', 'orchid_webp_'),
    ],
    'storage' => env('ORCHID_WEBP_STORAGE', 'filesystem'),
    'supported_mime_types' => [
        'image/jpeg',
        'image/png',
        'image/gif',
    ],
];