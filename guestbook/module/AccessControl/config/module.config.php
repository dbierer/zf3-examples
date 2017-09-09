<?php
namespace AccessControl;

use AccessControl\Acl\GuestbookAcl;
return [
    'service_manager' => [
        'factories' => [
            'access-control-datetime-assert' => Assertion\Factory\DateTimeAssertFactory::class,
            'access-control-guestbook-acl' => Acl\Factory\GuestbookAclFactory::class,
        ],
        'services' => [
            'access-control-config' => [
                'roles' => [
                    GuestbookAcl::DEFAULT_ROLE => '',
                    'user' => GuestbookAcl::DEFAULT_ROLE,
                    'admin' => 'user'
                ],
                'resources' => [
                    'guestbook'       => Guestbook\Controller\GuestbookController::class,
                    'login'           => Login\Controller\IndexController::class,
                    'messages'        => PrivateMessages\Controller\IndexController::class,
                    'app-index'       => Application\Controller\IndexController::class,
                    'events-index'    => Events\Controller\IndexController::class,
                    'events-tb-index' => Events\TableModule\Controller\IndexController::class,
                    'events-tb-admin' => Events\TableModule\Controller\AdminController::class,
                    'events-tb-sign'  => Events\TableModule\Controller\SignupController::class,
                    'events-doc-index'=> Events\Doctrine\Controller\IndexController::class,
                    'events-doc-admin'=> Events\Doctrine\Controller\AdminController::class,
                    'events-doc-sign' => Events\Doctrine\Controller\SignupController::class,
                ],
                'rights' => [
                    GuestbookAcl::DEFAULT_ROLE => [
                        ['login'            => ['allow' => '*']],
                        ['guestbook'        => ['allow' => '*']],
                        ['app-index'        => ['allow' => '*']],
                        ['events-index'     => ['allow' => '*']],
                        ['events-tb-index'  => ['allow' => '*']],
                        ['events-tb-sign'   => ['allow' => '*']],
                        ['events-doc-index' => ['allow' => '*']],
                        ['events-doc-sign'  => ['allow' => '*']],
                    ],
                    'user' => [
                        ['messages'  => ['allow' => '*']],
                    ],
                    'admin' => [
                        ['events-tb-admin'   => ['allow' => '*', 'assert' => 'access-control-datetime-assert']],
                        ['events-doc-admin' => ['allow' => '*', 'assert' => 'access-control-datetime-assert']],
                    ],
                ],
                'assertions' => [
                    'date-time-assert-config' => [
                        'start' => ['hour' => 9, 'minute' => 0, 'second' => 0],
                        'stop'  => ['hour' => 22, 'minute' => 0, 'second' => 0],
                    ],
                ],
            ],
        ],
    ],
];
