<?php
return [
    'service_manager' => [
        'services' => [
            'local-db-config' => [
                'driver' => 'pdo_mysql',
                'dsn' => 'mysql:host=localhost;dbname=course',
                'username' => 'test',
                'password' => 'password',
                'options' => [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION],
            ],
        ],
    ],
];
