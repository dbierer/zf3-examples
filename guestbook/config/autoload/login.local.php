<?php
return [
    'service_manager' => [
        'services' => [
            'login-block-cipher-config' => [
                // NOTE: DO NOT use 'mcrypt'!!!
                'openssl',
                [
                    // AES algorithm == Advanced Encrytion Standard 
                    'algo' => 'aes', 
                    // GCM == Galois Counter Mode ... WAY better than older ones like ECB
                    // only supported in PHP 7.1+
                    'mode' => 'gcm'
                ]
            ],
        ],
    ],
];
