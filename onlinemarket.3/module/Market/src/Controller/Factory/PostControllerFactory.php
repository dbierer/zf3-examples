<?php
namespace Market\Controller\Factory;

use Market\Controller\PostController;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class PostControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $controller = new PostController();
        $controller->setListingsTable($container->get('model-listings-table'));
        $controller->setPostForm($container->get('Market\Form\PostForm'));
        $controller->setFlash($container->get('Market\Plugin\Flash'));
        return $controller;
    }
}
