<?php
namespace Events;

use PDO;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;
use Zend\Mvc\Controller\LazyControllerAbstractFactory;
use Zend\Mvc\I18n\Router\TranslatorAwareTreeRouteStack;

return [
    'navigation' => [
        'default' => [
            'events' => ['label' => 'Events', 'route' => 'events', 'resource' => 'menu-events']
        ]
    ],
    'router' => [
        //'router_class' => TranslatorAwareTreeRouteStack::class,
        'routes' => [
            'events' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/events',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
                'may_terminate' => TRUE,
                'child_routes' => [
                    'table-module' => [
                        'type'    => Literal::class,
                        'options' => [
                            'route'    => '/table-module',
                            'defaults' => [
                                'controller' => Controller\IndexController::class,
                                'action'     => 'index',
                            ],
                        ],
                        'may_terminate' => TRUE,
                        'child_routes' => [
                            'admin' => [
                                'type'    => Segment::class,
                                'options' => [
                                    'route'    => '/admin[/][:event]',
                                    'defaults' => [
                                        'controller' => TableModule\Controller\AdminController::class,
                                        'action'     => 'index',
                                    ],
                                    'constraints' => [
                                        'event' => '[0-9]+',
                                    ],
                                ],
                            ],
                            'signup' => [
                                'type'    => Segment::class,
                                'options' => [
                                    // example of translatable route:
                                    //'route'    => '/{signup}[/][:event]',
                                    'route'    => '/signup[/][:event]',
                                    'defaults' => [
                                        'controller' => TableModule\Controller\SignupController::class,
                                        'action'     => 'index',
                                    ],
                                    'constraints' => [
                                        'event' => '[0-9]+',
                                    ],
                                ],
                            ],
                        ],
                    ],
                    'doctrine' => [
                        'type'    => Literal::class,
                        'options' => [
                            'route'    => '/doctrine',
                            'defaults' => [
                                'controller' => Controller\IndexController::class,
                                'action'     => 'index',
                            ],
                        ],
                        'may_terminate' => TRUE,
                        'child_routes' => [
                            'admin' => [
                                'type'    => Segment::class,
                                'options' => [
                                    'route'    => '/admin[/][:event]',
                                    'defaults' => [
                                        'controller' => Doctrine\Controller\AdminController::class,
                                        'action'     => 'index',
                                    ],
                                    'constraints' => [
                                        'event' => '[0-9]+',
                                    ],
                                ],
                            ],
                            'signup' => [
                                'type'    => Segment::class,
                                'options' => [
                                    'route'    => '/signup[/][:event]',
                                    'defaults' => [
                                        'controller' => Doctrine\Controller\SignupController::class,
                                        'action'     => 'index',
                                    ],
                                    'constraints' => [
                                        'event' => '[0-9]+',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'service_manager' => [
        'factories' => [
            TableModule\Model\EventTable::class        => InvokableFactory::class,
            TableModule\Model\AttendeeTable::class     => InvokableFactory::class,
            TableModule\Model\RegistrationTable::class => InvokableFactory::class,
            Doctrine\Entity\Event::class               => InvokableFactory::class,
            Doctrine\Entity\Attendee::class            => InvokableFactory::class,
            Doctrine\Entity\Registration::class        => InvokableFactory::class,
        ],
        'services' => [
            'events-menu-config' => [
                'events-table-module' => [
                    'label' => 'Table Module', 
                    'route' => 'events',
                    'resource' => 'menu-events-tm',
                    'pages' => [
                        ['label' => 'Sign Up Form', 'route' => 'events/table-module/signup', 'resource' => 'menu-events-tm-signup',
                            'pages' => [
                                ['label' => 'Event A', 'route' => 'events/table-module/signup', 'params' => ['event' => 1]],
                                ['label' => 'Event B', 'route' => 'events/table-module/signup', 'params' => ['event' => 2]],                            
                            ],
                        ],
                        ['label' => 'Admin Area', 'route' => 'events/table-module/admin', 'resource' => 'menu-events-tm-admin',
                            // do not need ACL "resource" for pages below this
                            'pages' => [
                                ['label' => 'Event A', 'route' => 'events/table-module/admin', 'params' => ['event' => 1]],
                                ['label' => 'Event B', 'route' => 'events/table-module/admin', 'params' => ['event' => 2]],
                            ],
                        ],
                    ],
                ],
                'events-doctrine' => [
                    'label' => 'Doctrine', 
                    'route' => 'events',
                    'resource' => 'menu-events-doc',
                    'pages' => [
                        ['label' => 'Sign Up Form', 'route' => 'events/doctrine/signup', 'resource' => 'menu-events-doc-signup',
                            'pages' => [
                                ['label' => 'Event A', 'route' => 'events/doctrine/signup', 'params' => ['event' => 1]],
                                ['label' => 'Event B', 'route' => 'events/doctrine/signup', 'params' => ['event' => 2]],
                            ],
                        ],
                        ['label' => 'Admin Area', 'route' => 'events/doctrine/admin', 'resource' => 'menu-events-doc-admin',
                            // do not need ACL "resource" for pages below this
                            'pages' => [
                                ['label' => 'Event A', 'route' => 'events/doctrine/admin', 'params' => ['event' => 1]],
                                ['label' => 'Event B', 'route' => 'events/doctrine/admin', 'params' => ['event' => 2]],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'abstract_factories' => [
            LazyControllerAbstractFactory::class,
        ],
        'factories' => [
            Controller\IndexController::class => LazyControllerAbstractFactory::class,
            TableModule\Controller\IndexController::class  => InvokableFactory::class,
            TableModule\Controller\AdminController::class  => InvokableFactory::class,
            TableModule\Controller\SignupController::class => InvokableFactory::class,
            Doctrine\Controller\IndexController::class  => InvokableFactory::class,
            Doctrine\Controller\SignupController::class => InvokableFactory::class,
            Doctrine\Controller\AdminController::class  => InvokableFactory::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [__DIR__ . '/../view'],
    ],
];
