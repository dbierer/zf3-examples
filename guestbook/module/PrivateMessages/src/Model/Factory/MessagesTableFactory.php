<?php
namespace PrivateMessages\Model\Factory;

use PrivateMessages\Model\ {Message, MessagesTable};
    
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class MessagesTableFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        $table = new MessagesTable();
        $table->setTableGateway($container->get('login-db-adapter'), new Message());
        return $table;
    }
}
