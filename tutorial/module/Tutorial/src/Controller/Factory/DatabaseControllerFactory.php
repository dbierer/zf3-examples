<?php
namespace Tutorial\Controller\Factory;

use Tutorial\Controller\DatabaseController;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class DatabaseControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $controller = new DatabaseController();
        $controller->setAdapter($container->get('tutorial-adapter'));
        $controller->setTable($container->get('tutorial-table'));
        return $controller;
    }
}
