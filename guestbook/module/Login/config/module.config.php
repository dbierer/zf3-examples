<?php
namespace Login;

use PDO;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'navigation' => [
        'default' => [
            'login' => ['label' => 'Login', 'uri' => '/login/login', 'tag' => __NAMESPACE__, 'resource' => 'menu-login-login'],
            'logout' => ['label' => 'Logout', 'uri' => '/login/logout', 'tag' => __NAMESPACE__, 'resource' => 'menu-login-logout']
        ]
    ],
    'router' => [
        'routes' => [
            'login' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/login[/:action]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'service_manager' => [
        'factories' => [
            Form\Login::class => Form\Factory\LoginFormFactory::class,
            Form\Register::class => Form\Factory\RegisterFormFactory::class,
            Form\Question::class => Form\Factory\QuestionFormFactory::class,
            Model\UsersTable::class => Model\Factory\UsersTableFactory::class,
        ],
        // override in /config/autoload/login.local.php
        'services' => [
            'login-storage-filename' => __DIR__ . '/../../../data/auth/storage.txt',
            'login-block-cipher-config' => [
                'openssl', ['algo' => 'aes', 'mode' => 'gcm']
            ],
            'login-locale-list' => ['en' => 'English','fr' => 'Français','de' => 'Deutsch','es' => 'Español'],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => Controller\Factory\IndexControllerFactory::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
