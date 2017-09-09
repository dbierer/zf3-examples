<?php
namespace AuthOauth\Generic;
use Zend\EventManager\Event as ZendEvent;
use Zend\ServiceManager\ServiceManager;
class Event extends ZendEvent
{
    const EVENT_ADD_OAUTH_USER = 'auth-oauth-add-user';    
    const EVENT_CHANNEL        = 'auth-oauth-channel';
}
