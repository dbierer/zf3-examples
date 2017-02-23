<?php
namespace Market;

use Market\Plugin\ {Flash, Csrf};
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\View\Helper as ViewHelper;
use Zend\Form\View\Helper as FormHelper;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'market' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/market',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'post' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/post[/]',
                            'defaults' => [
                                'controller' => Controller\PostController::class,
                                'action'     => 'index',
                            ],
                        ],
                    ],
                    'delete' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/delete',
                            'defaults' => [
                                'controller' => Controller\DeleteController::class,
                                'action'     => 'index',
                            ],
                        ],
                        'may_terminate' => true,
                        'child_routes' => [
                            'confirm' => [
                                'type' => Segment::class,
                                'options' => [
                                    'route' => '/confirm/:itemId',
                                    'defaults' => [
                                        'action'     => 'index',
                                    ],
                                    'constraints' => [
                                        'itemId' => '[0-9]+',
                                    ],
                                ],
                            ],
                            'process' => [
                                'type' => Segment::class,
                                'options' => [
                                    'route' => '/process[/]',
                                    'defaults' => [
                                        'action'     => 'process',
                                    ],
                                ],
                            ],
                        ],
                    ],
                    'view' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/view',
                            'defaults' => [
                                'controller' => Controller\ViewController::class,
                                'action'     => 'index',
                            ],
                        ],
                        'may_terminate' => true,
                        'child_routes' => [
                            'slash' => [
                                'type' => Segment::class,
                                'options' => [
                                    'route' => '/',
                                ],
                            ],
                            'category' => [
                                'type' => Segment::class,
                                'options' => [
                                    'route' => '/category[/:category]',
                                    'constraints' => [
                                        'category' => '[A-Za-z0-9]*',
                                    ],
                                    'defaults' => [
                                        'action'     => 'index',
                                    ],
                                ],
                            ],
                            'item' => [
                                'type' => Segment::class,
                                'options' => [
                                    'route' => '/item[/:itemId]',
                                    'constraints' => [
                                        'itemId' => '[0-9]*',
                                    ],
                                    'defaults' => [
                                        'action'     => 'item',
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
        'services' => [
            // defined in config/autoload/global.php
            /*
            'market-categories' => [],
		    'market-expire-days' => [],
			'market-captcha-options' => [],
            */
        ],
        'factories' => [
            Flash::class => InvokableFactory::class,
            Csrf::class => InvokableFactory::class,
            Form\PostForm::class => Form\Factory\PostFormFactory::class,
            Form\PostFilter::class => Form\Factory\PostFilterFactory::class,
            Form\DeleteForm::class => Form\Factory\DeleteFormFactory::class,
            Form\DeleteFormFilter::class => Form\Factory\DeleteFormFilterFactory::class,
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => Controller\Factory\IndexControllerFactory::class,
            Controller\ViewController::class => Controller\Factory\ViewControllerFactory::class,
            Controller\PostController::class => Controller\Factory\PostControllerFactory::class,
            Controller\DeleteController::class => Controller\Factory\DeleteControllerFactory::class,
        ],
    ],
    'view_manager' => [
      'template_path_stack' => [__DIR__ . '/../view'],
    ],
    'view_helpers' => [
        'factories' => [
            Helper\LeftLinks::class => InvokableFactory::class,
            FormHelper\Form::class => InvokableFactory::class,
            FormHelper\FormRow::class => InvokableFactory::class,
            FormHelper\FormLabel::class => InvokableFactory::class,
            FormHelper\FormCaptcha::class => InvokableFactory::class,
            FormHelper\FormEmail::class => InvokableFactory::class,
            FormHelper\FormHidden::class => InvokableFactory::class,
            FormHelper\FormRadio::class => InvokableFactory::class,
            FormHelper\FormSelect::class => InvokableFactory::class,
            FormHelper\FormSubmit::class => InvokableFactory::class,
            FormHelper\FormText::class => InvokableFactory::class,
            FormHelper\FormTextarea::class => InvokableFactory::class,
            FormHelper\FormCollection::class => InvokableFactory::class,
            FormHelper\FormElement::class => InvokableFactory::class,
            FormHelper\FormElementErrors::class => InvokableFactory::class,
            FormHelper\Captcha\Image::class => InvokableFactory::class,
            ViewHelper\FlashMessenger::class => InvokableFactory::class,
        ],
        'aliases' => [
            'leftLinks' => Helper\LeftLinks::class,
            'form' => FormHelper\Form::class,
            'formrow' => FormHelper\FormRow::class,
            'formcaptcha' => FormHelper\FormCaptcha::class,
            'formemail' => FormHelper\FormEmail::class,
            'formhidden' => FormHelper\FormHidden::class,
            'formradio' => FormHelper\FormRadio::class,
            'formselect' => FormHelper\FormSelect::class,
            'formsubmit' => FormHelper\FormSubmit::class,
            'formtext' => FormHelper\FormText::class,
            'formtextarea' => FormHelper\FormTextarea::class,
            'formcollection' => FormHelper\FormCollection::class,
            'form_label' => FormHelper\FormLabel::class,
            'form_element' => FormHelper\FormElement::class,
            'form_element_errors' => FormHelper\FormElementErrors::class,
            'captcha/image' => FormHelper\Captcha\Image::class,
        ],
    ],
];
