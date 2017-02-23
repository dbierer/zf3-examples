<?php
namespace Model\Table\Factory;

use Model\Table\Listings;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ListingsTable implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new Listings(Listings::TABLE_NAME, $container->get('model-primary-adapter'));
    }
}
