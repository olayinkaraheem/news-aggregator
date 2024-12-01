<?php

use App\Enums\NewsProviderEnum;

return [
    NewsProviderEnum::NEWSAPI->value => [
        'base_url' => env('NEWS_API_BASE_URL'),
        'api_key' => env('NEWS_API_KEY'),
        'page_size' => env('NEWS_API_PAGE_SIZE', 100),
        'paths' => [
            'top_headlines' => 'top-headlines',
            'everything' => 'everything',
            'sources' => 'sources'
        ]
        ],
    NewsProviderEnum::THE_GUARDIAN->value => [
        'base_url' => env('THE_GUARDIAN_BASE_URL'),
        'api_key' => env('THE_GUARDIAN_API_KEY'),
        'page_size' => env('THE_GUARDIAN_API_PAGE_SIZE', 10),
        'paths' => [
            'search' => 'search',
            'tags' => 'tags',
            'sections' => 'sections'
        ]
    ]
];