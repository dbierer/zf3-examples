<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Tutorial;

use PDO;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;
use Zend\Form\Element;
use Zend\Hydrator\ArraySerializable;
use Zend\Form\View\Helper as FormHelper;

return [
    'router' => [
        'routes' => [
            'tutorial' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/tutorial',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
                'may_terminate' => false,
                'child_routes' => [
                    'home' => [
                        'type' => Literal::class,
                        'options' => [
                            'route'    => '/home',
                            'defaults' => [
                                'action'     => 'home',
                                'config'     => __FILE__
                            ],
                        ],
                    ],
                    'name' => [
                        'type' => Segment::class,
                        'options' => [
                            'route'    => '/name[/:firstName][/:lastName]',
                            'defaults' => [
                                'action'     => 'index',
                            ],
                            'constraints' => [
                                'firstName' => '[a-zA-Z0-9_-]+',
                                'lastName' => '[a-zA-Z0-9_-]+',
                            ],
                        ],
                    ],
                    'google' => [
                        'type' => Literal::class,
                        'options' => [
                            'route'    => '/google',
                            'defaults' => [
                                'action'     => 'google',
                            ],
                        ],
                    ],
                    'info' => [
                        'type' => Literal::class,
                        'options' => [
                            'route'    => '/info',
                            'defaults' => [
                                'controller' => Controller\InfoController::class,
                                'action'     => 'index',
                            ],
                        ],
                        'may_terminate' => false,
                        'child_routes' => [
                            'key' => [
                                'type' => Segment::class,
                                'options' => [
                                    'route'    => '[/:infoKey]',
                                    'defaults' => [
                                        'action'     => 'index',
                                    ],
                                    'constraints' => [
                                        'infoKey' => '[A-Za-z]+'
                                    ]
                                ],
                            ],
                            'form' => [
                                'type' => Segment::class,
                                'options' => [
                                    'route'    => '/form[/]',
                                    'defaults' => [
                                        'action'     => 'form',
                                    ],
                                ],
                            ],
                        ],
                    ],
                    'database' => [
                        'type' => Literal::class,
                        'options' => [
                            'route'    => '/db',
                            'defaults' => [
                                'controller' => Controller\DatabaseController::class,
                                'action'     => 'index',
                            ],
                        ],
                        'may_terminate' => false,
                        'child_routes' => [
                            'query' => [
                                'type' => Segment::class,
                                'options' => [
                                    'route'    => '/query[/:id]',
                                    'defaults' => [
                                        'action'     => 'query',
                                    ],
                                    'constraints' => [
                                        'id' => '[0-9]*',
                                    ],
                                ],
                            ],
                            'table' => [
                                'type' => Segment::class,
                                'options' => [
                                    'route'    => '/table[/:id]',
                                    'defaults' => [
                                        'action'     => 'table',
                                    ],
                                    'constraints' => [
                                        'id' => '[0-9]*',
                                    ],
                                ],
                            ],
                            'delete' => [
                                'type' => Segment::class,
                                'options' => [
                                    'route'    => '/delete[/:id]',
                                    'defaults' => [
                                        'action'     => 'delete',
                                    ],
                                    'constraints' => [
                                        'id' => '[0-9]*',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => InvokableFactory::class,
            Controller\InfoController::class => Controller\Factory\InfoControllerFactory::class,
            Controller\DatabaseController::class => Controller\Factory\DatabaseControllerFactory::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [__DIR__ . '/../view'],
        /*
        'template_map' => [
            'tutorial/index/index' => __DIR__ . '/../view/tutorial/index/index.phtml',
        ],
        */
    ],
    'service_manager' => [
        'services' => [
            'tutorial-info-config' => [
                'google' => ['website' => 'http://google.com/', 'owner' => 'Eric Schmidt', 'notes' => 'Search'],
                'unlikelysource' => ['website' => 'http://unlikelysource.com/', 'owner' => 'Doug Bierer', 'notes' => 'PHP Stuff'],
            ],
            'tutorial-adapter-config' => [
                'driver' => 'PDO',
                'dsn' => 'mysql:host=localhost;dbname=tutorial',
                'driver_options' => [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION],
                'username' => 'zend',
                'password' => 'password',
            ],
            'tutorial-filter-config' => [
                // Configuration to pass on to
                // Zend\InputFilter\Factory::createInputFilter()
                'input_filter' => [
                    'name' =>
                        [
                            'name' => 'name',
                            'required' => true,
                            'filters' => [
                                [
                                    'name' => 'Zend\Filter\StringTrim',
                                    'options' => [],
                                ],
                                [
                                    'name' => 'Zend\Filter\StripTags',
                                    'options' => [],
                                ],
                            ],
                            'validators' => [
                                [
                                    'name' => 'Zend\I18n\Validator\Alnum',
                                    'options' => [],
                                ],
                            ],
                            'description' => 'Member Name',
                            'allow_empty' => false,
                            'continue_if_empty' => false,
                        ],
                    'email' =>
                        [
                            'name' => 'email',
                            'required' => true,
                            'filters' => [
                                [
                                    'name' => 'Zend\Filter\StringTrim',
                                    'options' => [],
                                ],
                                [
                                    'name' => 'Zend\Filter\StripTags',
                                    'options' => [],
                                ],
                            ],
                            'validators' => [
                                [
                                    'name' => 'Zend\Validator\EmailAddress',
                                    'options' => [],
                                ],
                            ],
                            'description' => 'Email Address',
                            'allow_empty' => false,
                            'continue_if_empty' => false,
                        ],
                ],
            ],
            'tutorial-form-config' => [
                'hydrator' => ArraySerializable::class,
                'elements' => [
                    [
                        'spec' => [
                            'name' => 'name',
                            'type'  => Element\Text::class,
                            'attributes' => ['title' => 'Names can only consist of letters and numbers', 'size' => 40, 'maxlength' => 128],
                            'options' => [
                                'label' => 'User Name',
                            ],
                        ],
                    ],
                    [
                        'spec' => [
                            'name' => 'email',
                            'type' => Element\Email::class,
                            'attributes' => ['placeholder' => 'example@company.com', 'size' => 60, 'maxlength' => 128],
                            'options' => [
                                'label' => 'Email Address',
                                'attributes' => ['type' => 'email'],
                            ]
                        ],
                    ],
                    [
                        'spec' => [
                            'name' => 'send',
                            'type'  => 'Submit',
                            'attributes' => [
                                'value' => 'Submit',
                            ],
                        ],
                    ],
                ],
            ],
        ],
        'factories' => [
            'tutorial-info-list' => Model\Factory\InfoFactory::class,
            'tutorial-form' => Form\Factory\FormFactory::class,
            'tutorial-filter' => Form\Factory\FilterFactory::class,
            'tutorial-adapter' => Model\Factory\AdapterFactory::class,
            'tutorial-table' => Model\Factory\TutorialTableFactory::class,
        ],
    ],
    'view_helpers' => [
        'factories' => [
            FormHelper\Form::class => InvokableFactory::class,
        ],
        'aliases' => [
            'form' => FormHelper\Form::class,
        ],
    ],
    'view_helpers' => [
        'factories' => [
            FormHelper\Form::class => InvokableFactory::class,
            FormHelper\FormRow::class => InvokableFactory::class,
            FormHelper\FormLabel::class => InvokableFactory::class,
            FormHelper\FormCaptcha::class => InvokableFactory::class,
            FormHelper\FormEmail::class => InvokableFactory::class,
            FormHelper\FormRadio::class => InvokableFactory::class,
            FormHelper\FormSelect::class => InvokableFactory::class,
            FormHelper\FormSubmit::class => InvokableFactory::class,
            FormHelper\FormText::class => InvokableFactory::class,
            FormHelper\FormTextarea::class => InvokableFactory::class,
            FormHelper\FormCollection::class => InvokableFactory::class,
            FormHelper\FormElement::class => InvokableFactory::class,
            FormHelper\FormElementErrors::class => InvokableFactory::class,
            FormHelper\Captcha\Image::class => InvokableFactory::class,
        ],
        'aliases' => [
            'form' => FormHelper\Form::class,
            'formRow' => FormHelper\FormRow::class,
            'formCaptcha' => FormHelper\FormCaptcha::class,
            'formEmail' => FormHelper\FormEmail::class,
            'formRadio' => FormHelper\FormRadio::class,
            'formSelect' => FormHelper\FormSelect::class,
            'formSubmit' => FormHelper\FormSubmit::class,
            'formText' => FormHelper\FormText::class,
            'formTextarea' => FormHelper\FormTextarea::class,
            'formCollection' => FormHelper\FormCollection::class,
            'formLabel' => FormHelper\FormLabel::class,
            'formElement' => FormHelper\FormElement::class,
            'formElementErrors' => FormHelper\FormElementErrors::class,
            'captcha/image' => FormHelper\Captcha\Image::class,
        ],
    ],
];
