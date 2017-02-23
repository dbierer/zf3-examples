<?php
namespace Market\Form\Factory;

use Market\Form\PostFilter;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class PostFilterFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $filter = new PostFilter();
        $filter->setExpireDays($container->get('market-expire-days'));
        $filter->setCategories($container->get('market-categories'));
        $filter->buildFilter();
        return $filter;
    }
}
