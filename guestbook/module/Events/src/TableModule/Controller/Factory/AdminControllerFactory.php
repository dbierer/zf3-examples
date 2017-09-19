<?php
namespace Events\TableModule\Controller\Factory;

use Events\TableModule\Controller\AdminController;
use Events\TableModule\Model\ {EventTable,RegistrationTable};
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;


class AdminControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        $controller = new AdminController();
        $controller->setEventTable($container->get(EventTable::class));
        $controller->setRegistrationTable($container->get(RegistrationTable::class));
        return $controller;
    }
}
