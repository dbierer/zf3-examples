<?php
namespace Market\Form\Factory;

use Market\Form\DeleteFormFilter;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class DeleteFormFilterFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $filter = new DeleteFormFilter();
        $filter->prepareFilters();
        return $filter;
    }
}
