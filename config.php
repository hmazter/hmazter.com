<?php

return [
    'baseUrl' => 'http://localhost:3000',

    'site_title' => 'hmazter.com',
    'site_description' => 'Web and application development',

    'production' => false,
    'collections' => [
        'posts' => [
            'path' => '{date|Y/m}/{slug}',
            'sort' => '-date',
            'postDescription' => function ($page) {
                return $page->description ?? $page->excerpt();
            },
            'excerpt' => function ($page, $characters = 100) {
                $content = strip_tags($page->getContent());
                return str_limit($content, $characters);
            },
        ],
        'portfolio' => [
            'path' => 'portfolio/{filename}',
            'sort' => 'sort'
        ],
    ],
];
