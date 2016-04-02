<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production

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
