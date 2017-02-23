<?php
namespace Tutorial\Model\Factory;

use Tutorial\Model\TutorialTable;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\Db\TableGateway\TableGateway;

class TutorialTableFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new TutorialTable(TutorialTable::TABLE_NAME, $container->get('tutorial-adapter'));
    }
}
