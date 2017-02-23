<?php
namespace Tutorial\Controller\Factory;

use Tutorial\Controller\InfoController;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class InfoControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $controller = new InfoController();
        $controller->setInfoItems($container->get('tutorial-info-list'));
        $controller->setForm($container->get('tutorial-form'));
        $controller->setTable($container->get('tutorial-table'));
        return $controller;
    }
}
