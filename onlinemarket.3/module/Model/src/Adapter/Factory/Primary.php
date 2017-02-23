<?php
namespace Model\Adapter\Factory;

use Zend\Db\Adapter\Adapter;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class Primary implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new Adapter($container->get('model-primary-adapter-config'));
    }
}
