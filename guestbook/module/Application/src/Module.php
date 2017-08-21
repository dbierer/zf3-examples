<?php
namespace Application;
use Zend\Mvc\MvcEvent;
use Application\Event\AppEvent;
use Application\Event\Listener\ {ErrorLog, ErrorLogWithFilter};
use Zend\EventManager\LazyListener;
class Module
{
    const VERSION = '3.0.3-dev';

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
    
    public function onBootstrap(MvcEvent $e)
    {
        $container = $e->getApplication()->getServiceManager();
        $em = $e->getApplication()->getEventManager();
        // lazy listener
        $em->attach(
            AppEvent::EVENT_LOG, 
            new LazyListener([
                'listener' => ErrorLog::class, 
                'method' => 'logMessage'], 
                $container),
            100);
        // listener with filter
        /*
        $em->attach(
            AppEvent::EVENT_LOG_FILTER, 
            [$container->get(ErrorLogWithFilter::class), 'logMessage'],
            100);
        */
    }
}
