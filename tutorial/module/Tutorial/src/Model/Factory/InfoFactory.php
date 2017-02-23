<?php
namespace Tutorial\Model\Factory;

use Tutorial\Model\Info;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class InfoFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $result = [];
        foreach ($container->get('tutorial-info-config') as $config) {
            $result[] = new Info($config['website'], $config['owner'], $config['notes']);
        }
        return $result;
    }
}
