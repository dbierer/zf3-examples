<?php
namespace PrivateMessages;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;
use Zend\I18n\View\Helper\DateFormat;

return [
    'navigation' => [
        'default' => [
            'messages' => ['label' => 'Messages', 'route' => 'messages']
        ]
    ],
    'router' => [
        'routes' => [
            'messages' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/messages[/:action]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'keypairs' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/keypairs[/:action]',
                    'defaults' => [
                        'controller' => Controller\KeypairsController::class,
                        'action'     => 'diffie',
                    ],
                ],
            ],
        ],
    ],
    'service_manager' => [
        'factories' => [
            Form\Send::class => Form\Factory\SendFormFactory::class,
            Model\MessagesTable::class => Model\Factory\MessagesTableFactory::class,
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => Controller\Factory\IndexControllerFactory::class,
            Controller\KeypairsController::class => InvokableFactory::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [__DIR__ . '/../view'],
    ],
];
