<?php
namespace Events\TableModule\Controller\Factory;

use Events\TableModule\Controller\SignupController;
use Events\TableModule\Model\ {EventTable,RegistrationTable, AttendeeTable};
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;


class SignupControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        $controller = new SignupController();
        $controller->setEventTable($container->get(EventTable::class));
        $controller->setRegistrationTable($container->get(RegistrationTable::class));
        $controller->setAttendeeTable($container->get(AttendeeTable::class));
        $controller->setRegDataFilter($container->get('events-reg-data-filter'));
        return $controller;
    }
}
