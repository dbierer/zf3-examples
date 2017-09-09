<?php
namespace Login\Form\Factory;

use Zend\Hydrator\ClassMethods;
use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

use Login\Form\Register as RegisterForm;

class RegisterFormFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        $form = new RegisterForm('register');
        $form->setLocaleList($container->get('login-locale-list'));
        $form->addElements();
        $form->addInputFilter();
        $form->setHydrator(new ClassMethods());
        return $form;
    }
}
