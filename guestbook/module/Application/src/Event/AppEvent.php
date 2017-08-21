<?php
namespace Application\Event;
use Zend\EventManager\Event;
class AppEvent extends Event
{
    const EVENT_LOG = 'application-event-error-log';
    const EVENT_LOG_FILTER = 'application-event-error-log-with-filter';
}
