<?php
namespace Login\Model\Factory;

use Login\Model\ {User, UsersTable};
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class UsersTableFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        $table = new UsersTable();
        $table->setTableGateway($container->get('login-db-adapter'), new User());
        return $table;
    }
}
