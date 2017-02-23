<?php
namespace Market\Controller\Factory;

use Market\Controller\IndexController;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class IndexControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $controller = new IndexController();
        $controller->setFlash($container->get('Market\Plugin\Flash'));
        $controller->setListingsTable($container->get('model-listings-table'));
        return $controller;
    }
}
