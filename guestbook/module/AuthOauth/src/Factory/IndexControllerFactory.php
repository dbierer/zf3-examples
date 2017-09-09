<?php
namespace AuthOauth\Factory;

use AuthOauth\Adapter\GoogleAdapter;
use AuthOauth\Controller\IndexController;
use Zend\Authentication\AuthenticationService;
use Zend\ServiceManager\ServiceLocatorInterface;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class IndexControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        return $this->getController($container);
    }
    private function getController($manager)
    {
        $controller = new IndexController();
        $controller->setAuthService($manager->get('auth-oauth-service'));
        // NOTE: this setter invokes AdapterAbstractFactory
        $controller->setAuthAdapterGoogle($manager->get('auth-oauth-adapter-google'));
        return $controller;
    }
}
