<?php
namespace Tutorial\Form\Factory;

use Zend\InputFilter\Factory as ZIF;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class FilterFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return (new ZIF())->createInputFilter($container->get('tutorial-filter-config')['input_filter']);
    }
}
