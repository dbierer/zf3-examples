<?php
namespace Market\Controller\Factory;

use Market\Controller\ViewController;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ViewControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $controller = new ViewController();
        $controller->setListingsTable($container->get('model-listings-table'));
        return $controller;
    }
}
