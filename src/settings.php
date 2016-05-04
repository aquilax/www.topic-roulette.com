<?php
return [
    'settings' => [
        'displayErrorDetails' => false, // set to false in production

        'site' => [
            'domain' => 'www.topic-roulette.com',
        ],

        // View settings
        'view' => [
            'template_path' => __DIR__ . '/../templates/',
            'cache_path' => false//__DIR__ . '/../cache/',
        ],

        'database' => [
            'dsn' => 'sqlite:'.__DIR__.'/../db/data.sqlite3',
        ]
    ],
];
