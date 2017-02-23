<?php
// modify settings as per your server
// copy this file to /config/autoload
return [
    'service_manager' => [
        'services' => [
            'notify-email-settings' => [
                'to' => 'info@example.com',
                'from' => 'info@example.com',
                'transport' => 'file',          // can be: sendmail | smtp | file
            ],
            'notify-transport-settings' => [
                'file' => [
                    'path' => __DIR__ . '/../../data/mail',
                ],
                'smtp' => [
                    'name'              => 'localhost.localdomain',
                    'host'              => '127.0.0.1',
                    'connection_class'  => 'plain',
                    'connection_config' => [
                        'username' => 'user',
                        'password' => 'pass',
                    ],
                ],
                // 'sendmail' => [],   // no options for sendmail
            ],
        ],
    ],
];
