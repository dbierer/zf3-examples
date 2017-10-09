<?php
namespace RestApi;

use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'rest-api' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/api[/:id]',
                    'defaults' => [
                        'controller' => Controller\ApiController::class,
                    ],
                    'constraints' => [
                        'id' => '[0-9]+',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\ApiController::class => Controller\Factory\ApiControllerFactory::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            Service\ApiService::class => Service\Factory\ApiServiceFactory::class,
        ],
    ],
    'view_manager' => [
        'strategies' => [ 'ViewJsonStrategy' ],
    ],
    'access-control-config' => [
        'resources' => [
            'rest-api-index'  => 'RestApi\Controller\ApiController',
        ],
        'rights' => [
            'guest' => [
                'rest-api-index'     => ['allow' => NULL],
            ],
        ],
    ],
];
