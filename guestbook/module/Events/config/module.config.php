<?php
namespace Events;

use PDO;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;
use Zend\Mvc\Controller\LazyControllerAbstractFactory;

return [
    'navigation' => [
        'default' => [
            'events' => ['label' => 'Events', 'route' => 'events']
        ]
    ],
    'router' => [
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
