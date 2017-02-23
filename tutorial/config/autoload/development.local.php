<?php
/**
 * Local Configuration Override for DEVELOPMENT MODE.
 *
 * This configuration override file is for providing configuration to use while
 * in development mode. Run:
 *
 * <code>
 * $ composer development-enable
 * </code>
 *
 * from the project root to copy this file to development.local.php and enable
 * the settings it contains.
 *
 * You may also create files matching the glob pattern `{,*.}{global,local}-development.php`.
 */

return [
    'view_manager' => [
        'display_exceptions' => true,
    ],
    'service_manager' => [
        'services' => [
            'tutorial-adapter-config' => [
                'driver' => 'PDO',
                'dsn' => 'mysql:host=localhost;dbname=tutorial',
                'driver_options' => [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION],
                'username' => 'vagrant',
                'password' => 'vagrant',
            ],
        ],
    ],
];
