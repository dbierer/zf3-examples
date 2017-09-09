<?php
namespace Guestbook\Listener;

use Guestbook\Controller\GuestbookController;
use Application\Traits\ServiceManagerTrait;

use Zend\Mvc\MvcEvent;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;

class CacheAggregate implements ListenerAggregateInterface
{
    
    use ServiceManagerTrait;
    
    const EVENT_CLEAR_CACHE = 'guestbook-event-clear-cache';
    const OUTPUT_CACHE_KEY = 'guestbook-index-index';
    
    public function attach(EventManagerInterface $e, $priority = 100)
    {
        $shared = $e->getSharedManager();
        $this->listeners[] = $shared->attach('*', MvcEvent::EVENT_DISPATCH, [$this, 'getIndexViewFromCache'], 99);
        $this->listeners[] = $shared->attach('*', MvcEvent::EVENT_FINISH, [$this, 'storeIndexViewToCache'], 99);
        $this->listeners[] = $shared->attach('*', self::EVENT_CLEAR_CACHE, [$this, 'clearCache'], $priority);
    }
    public function detach(EventManagerInterface $e, $priority = 100)
    {
        // do nothing
    }
    public function clearCache($e)
    {
        $cache = $this->serviceManager->get('cache-adapter');
        $cache->removeItem(self::OUTPUT_CACHE_KEY);
    }    
    public function getIndexViewFromCache(MvcEvent $e)
    {
        $routeMatch = $e->getRouteMatch();
        $controller = $routeMatch->getParam('controller');
        $action     = $routeMatch->getParam('action');
        if ($controller == GuestbookController::class && $action == 'index') {
            $cache = $this->serviceManager->get('cache-adapter');
            if ($cache->hasItem(self::OUTPUT_CACHE_KEY)) {
                return $cache->getItem(self::OUTPUT_CACHE_KEY);
            } else {
                $routeMatch->setParam('re-cache', TRUE);
            }
        }
    }    
    public function storeIndexViewToCache(MvcEvent $e)
    {
        $routeMatch = $e->getRouteMatch();
        if ($routeMatch->getParam('re-cache')) {
            $cache = $this->serviceManager->get('cache-adapter');
            $cache->setItem(self::OUTPUT_CACHE_KEY, $e->getResponse());
        }
    }
}
