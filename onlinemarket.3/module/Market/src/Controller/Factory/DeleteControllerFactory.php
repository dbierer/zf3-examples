<?php
namespace Market\Controller\Factory;

use Market\Controller\DeleteController;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DeleteControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $controller = new DeleteController();
        $controller->setCsrf($container->get('Market\Plugin\Csrf'));
        $controller->setFlash($container->get('Market\Plugin\Flash'));
        $controller->setDeleteForm($container->get('Market\Form\DeleteForm'));
        $controller->setListingsTable($container->get('model-listings-table'));
        return $controller;
    }
}
