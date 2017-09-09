<?php
namespace Login\Controller\Factory;

use Login\Controller\IndexController;
use Login\Form\Login as LoginForm;
use Login\Form\Register as RegForm;
use Login\Model\UsersTable;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;


class IndexControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        $controller = new IndexController();
        $controller->setTable($container->get(UsersTable::class));
        $controller->setRegForm($container->get(RegForm::class));
        $controller->setLoginForm($container->get(LoginForm::class));
        $controller->setAuthAdapter($container->get('login-auth-adapter'));
        $controller->setAuthService($container->get('login-auth-service'));
        $controller->setSessionContainer($container->get('application-session-container'));
        $controller->setSessionManager($container->get('application-session-manager'));
        return $controller;
    }
}
