<?php
namespace Tutorial\Model\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\Db\Adapter\Adapter;

class AdapterFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new Adapter($container->get('tutorial-adapter-config'));
    }
}
