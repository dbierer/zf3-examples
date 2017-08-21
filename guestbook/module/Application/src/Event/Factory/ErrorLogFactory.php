<?php
namespace Application\Event\Factory;

use Application\Event\Listener\ErrorLog;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class ErrorLogFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        $listener = new ErrorLog();
        $listener->setLogFileName($container->get('application-log-dir'), $container->get('application-log-filename'));
        return $listener;
    }
}
