<?php
namespace Application\Event\Listener;
use Application\Event\AppEvent;
use Zend\EventManager\SharedEventManagerInterface;
use Zend\EventManager\SharedListenerAggregateInterface;
class ErrorLogAggregate implements SharedListenerAggregateInterface
{
    public function attachShared(SharedEventManagerInterface $e, $priority = 100)
    {
        $this->listeners[] = $e->attach('*', AppEvent::EVENT_LOG, [$this, 'logMessage'], $priority);
    }
    public function detachShared(SharedEventManagerInterface $e, $priority = 100)
    {
        // do nothing
    }
    public function logMessage($e)
    {
        $whoTriggered = get_class($e->getTarget());
        $optMessage   = $e->getParam('message') ?? 'No Message';
        error_log(__METHOD__ . ':' . $whoTriggered . ':' . $optMessage);
    }
}
