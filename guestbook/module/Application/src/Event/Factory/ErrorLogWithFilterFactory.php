<?php
namespace Application\Event\Factory;

use Application\Event\Filter\MaskCcnum;
use Application\Event\Listener\ErrorLogWithFilter;
use Application\Controller\IndexController;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class ErrorLogWithFilterFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        $listener = new ErrorLogWithFilter();
        $listener->setLogFileName($container->get('application-log-dir'), $container->get('application-log-filename'));
        $filter   = new MaskCcnum();
        $listener->attachFilter([$filter, 'filter']);
        return $listener;
    }
}
