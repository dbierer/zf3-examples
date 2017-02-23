<?php
namespace Model;

return [
    'service_manager' => [
        'services' => [
            'model-primary-adapter-config' => [
                'driver' => 'PDO',
                'dsn' => 'mysql:hostname=localhost;dbname=onlinemarket',
                'username' => 'test',
                'password' => 'password',
            ],
        ],
        'factories' => [
            'model-primary-adapter' => Adapter\Factory\Primary::class,
            'model-listings-table' => Table\Factory\ListingsTable::class,
        ],
    ],

];
