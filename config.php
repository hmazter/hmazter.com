<?php

return [
    'baseUrl' => '',
    'production' => false,
    'collections' => [
        'posts' => [
            'path' => '{date|Y/m}/{slug}',
            'sort' => '-date'
        ],
        'portfolio' => [
            'path' => 'portfolio/{filename}',
            'sort' => 'sort'
        ],
    ],
];
