<?php
namespace Guestbook\Mapper\Factory;

use Guestbook\Mapper\Guestbook;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
class GuestbookMapperFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        $mapper = new Guestbook($container->get('guestbook-db-adapter'));
        return $mapper;
    }
}
