<?php
namespace AccessControl;

use AccessControl\Listener\AclListenerAggregate as AclListener;

return [
    'listeners' => [
        AclListener::class,
    ],
    'service_manager' => [
        'factories' => [
            'access-control-datetime-assert' => Assertion\Factory\DateTimeAssertFactory::class,
            'access-control-guestbook-acl' => Acl\Factory\GuestbookAclFactory::class,
        ],
        'services' => [
            'access-control-config' => [
                'roles' => [
                    AclListener::DEFAULT_ROLE => NULL,
                    'user' => AclListener::DEFAULT_ROLE,
                    'admin' => 'user',
                ],
                'resources' => [
                    'guestbook'       => 'Guestbook\Controller\GuestbookController',
                    'login'           => 'Login\Controller\IndexController',
                    'messages'        => 'PrivateMessages\Controller\IndexController',
                    'app-index'       => 'Application\Controller\IndexController',
                    'events-index'    => 'Events\Controller\IndexController',
                    'events-tb-index' => 'Events\TableModule\Controller\IndexController',
                    'events-tb-admin' => 'Events\TableModule\Controller\AdminController',
                    'events-tb-sign'  => 'Events\TableModule\Controller\SignupController',
                    'events-doc-index'=> 'Events\Doctrine\Controller\IndexController',
                    'events-doc-admin'=> 'Events\Doctrine\Controller\AdminController',
                    'events-doc-sign' => 'Events\Doctrine\Controller\SignupController',
                    'auth-oauth-index'=> 'AuthOauth\Controller\IndexController',
                    // menu resources
                    'menu-guestbook-home'   => 'menu-guestbook-home',
                    'menu-guestbook-sign'   => 'menu-guestbook-sign',
                    'menu-messages'         => 'menu-messages',
                    'menu-login-login'      => 'menu-login-login',
                    'menu-login-logout'     => 'menu-login-logout',
                    'menu-events'           => 'menu-events',
                    'menu-events-tm'        => 'menu-events-tm',
                    'menu-events-tm-signup' => 'menu-events-tm-signup',
                    'menu-events-tm-admin'  => 'menu-events-tm-admin',
                    'menu-events-doc'       => 'menu-events-doc',
                    'menu-events-doc-signup'=> 'menu-events-doc-signup',
                    'menu-events-doc-admin' => 'menu-events-doc-admin',
                    
                ],
                'rights' => [
                    AclListener::DEFAULT_ROLE => [
                        'login'            => ['allow' => ['login','register']],
                        'guestbook'        => ['allow' => NULL], // NULL == any rights
                        'app-index'        => ['allow' => NULL],
                        'events-index'     => ['allow' => NULL],
                        'events-tb-index'  => ['allow' => NULL],
                        'events-tb-sign'   => ['allow' => NULL],
                        'events-doc-index' => ['allow' => NULL],
                        'events-doc-sign'  => ['allow' => NULL],
                        'auth-oauth-index' => ['allow' => NULL],
                        // menu assignments
                        'menu-guestbook-home'   => ['allow' => NULL],
                        'menu-guestbook-sign'   => ['allow' => NULL],
                        'menu-login-login'      => ['allow' => NULL],
                        'menu-events'           => ['allow' => NULL],
                        'menu-events-tm'        => ['allow' => NULL],
                        'menu-events-tm-signup' => ['allow' => NULL],
                        'menu-events-doc'       => ['allow' => NULL],
                        'menu-events-doc-signup'=> ['allow' => NULL],
                    ],
                    'user' => [
                        'login'             => ['allow' => 'logout'],
                        'messages'          => ['allow' => NULL],
                        'menu-messages'     => ['allow' => NULL],
                        'menu-login-login'  => ['deny' => NULL],
                        'menu-login-logout' => ['allow' => NULL],
                    ],
                    'admin' => [
                        'events-tb-admin'  => ['allow' => NULL, 'assert' => 'access-control-datetime-assert'],
                        'events-doc-admin' => ['allow' => NULL, 'assert' => 'access-control-datetime-assert'],
                        'menu-events-tm-admin' => ['allow' => NULL, 'assert' => 'access-control-datetime-assert'],
                        'menu-events-doc-admin' => ['allow' => NULL, 'assert' => 'access-control-datetime-assert'],
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
