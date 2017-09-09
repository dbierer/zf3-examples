<?php
namespace Login\Form\Factory;

use Zend\Hydrator\ClassMethods;
use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

use Login\Form\Login as LoginForm;

class LoginFormFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        $form = new LoginForm('login');
        $form->setLocaleList($container->get('login-locale-list'));
        $form->addElements();
        $form->addInputFilter();
        return $form;
    }
}
