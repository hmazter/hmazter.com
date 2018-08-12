<?php

return [
    'baseUrl' => '',
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
