<?php
return [
    'service_manager' => [
        'services' => [
            'local-db-config' => [
                'driver' => 'pdo_mysql',
                'dsn' => 'mysql:host=localhost;dbname=course',
                'username' => 'vagrant',
                'password' => 'vagrant',
                'options' => [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION],
            ],
        ],
    ],
];
