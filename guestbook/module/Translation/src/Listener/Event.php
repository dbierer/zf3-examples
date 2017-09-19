<?php
namespace Translation\Listener;

use Zend\EventManager\Event as ZendEvent;
class Event extends ZendEvent
{
    const EVENT_LOCALE_USER = 'translation-set-locale-from-user';
    const EVENT_LOCALE_PARAM = 'translation-set-locale-from-param';
}
