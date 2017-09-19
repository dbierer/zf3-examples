<?php
return [
    'service_manager' => [
        'services' => [
            'local-db-config' => [
                'driver' => 'pdo_mysql',
                'dsn' => 'mysql:host=localhost;dbname=course',
<<<<<<< HEAD
                'username' => 'vagrant',
                'password' => 'vagrant',
=======
                'username' => 'test',
                'password' => 'password',
>>>>>>> 6ebbe84ea62f03134b7081afaa02a840fccfa36c
                'options' => [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION],
            ],
        ],
    ],
];
