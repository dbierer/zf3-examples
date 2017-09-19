<?php
namespace Guestbook;

use PDO;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'navigation' => [
        'default' => [
            'home' => ['label' => 'Home', 'route' => 'home', 'resource' => 'menu-guestbook-home'],
            'sign' => ['label' => 'Sign', 'uri' => '/guestbook/sign', 'resource' => 'menu-guestbook-sign']
        ]
    ],
    'router' => [
        'routes' => [
            'home' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => Controller\GuestbookController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'guestbook' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/guestbook[/:action]',
                    'defaults' => [
                        'controller' => Controller\GuestbookController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'service_manager' => [
        'services' => [
            'guestbook-audit-filename' => __DIR__ . '/../../../data/logs/guestbook_audit.log',
        ],
        'aliases' => [
            // config is in /config/autoload/db.local.php
            'guestbook-db-config' => 'local-db-config',
        ],
        'factories' => [
            Form\Guestbook::class => Form\Factory\GuestbookFormFactory::class,
            Mapper\Guestbook::class => Mapper\Factory\GuestbookMapperFactory::class,
            Listener\CacheAggregate::class => Listener\Factory\CacheAggregateFactory::class,
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\GuestbookController::class => Controller\Factory\GuestbookControllerFactory::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    'listeners' => [
        Listener\CacheAggregate::class,
    ],
];
