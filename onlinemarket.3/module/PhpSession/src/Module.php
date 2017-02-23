<?php
namespace PhpSession;

use Zend\Mvc\MvcEvent;
use Zend\Session\ {SessionManager, SessionConfig, Container};
use Zend\Session\Storage\SessionArrayStorage;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $em = $e->getApplication()->getEventManager();
        $em->attach(MvcEvent::EVENT_DISPATCH, [$this, 'startSession'], 99);
    }
    public function startSession(MvcEvent $e)
    {
        $sm = $e->getApplication()->getServiceManager();
        $sm->get(SessionManager::class)->start();
    }
    public function getServiceConfig()
    {
        return [
            'factories' => [
                SessionManager::class => function ()
                {
                    $sessionManager = new SessionManager();
                    $sessionManager->setStorage(new SessionArrayStorage());
                    Container::setDefaultManager($sessionManager);
                    return $sessionManager;
                },
            ],
        ];
    }
}
