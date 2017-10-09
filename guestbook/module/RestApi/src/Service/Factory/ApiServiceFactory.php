<?php
namespace RestApi\Service\Factory;

use RestApi\Service\ApiService;
use Events\TableModule\Model\ {EventTable, RegistrationTable, AttendeeTable};

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class ApiServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        $service = new ApiService();
        $service->setEventTable($container->get(EventTable::class));
        $service->setRegistrationTable($container->get(RegistrationTable::class));
        $service->setAttendeeTable($container->get(AttendeeTable::class));
        return $service;
    }
}
