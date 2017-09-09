<?php
namespace AccessControl;

use AccessControl\Acl\GuestbookAcl;
use Zend\Mvc\MvcEvent;

class Module
{
    const DEFAULT_ROLE = 'guest';
    public function getConfig()
    {
        return __DIR__ . '/../config/module.config.php';
    }
    public function onBootstrap(MvcEvent $e)
    {
        $em = $e->getApplication()->getEventManager();
        $em->attach(MvcEvent::EVENT_DISPATCH, [$this, 'checkAcl'], 999);
    }
    public function checkAcl(MvcEvent $e)
    {
        $sm = $e->getApplication()->getServiceManager();
        $acl = $sm->get('access-control-guestbook-acl');
        $authService = $sm->get('login-auth-service');
        $match = $e->getRouteMatch();
        $controller = $match->getParam('controller');
        $action = $match->getParam('action');
        $resources = $sm->get('access-control-config')['resources'];
        $denied = TRUE;
        if ($authService->hasIdentity()) {
            $role = $authService->getIdentity()->getRole() ?? GuestbookAcl::DEFAULT_ROLE;
        } else {
            $role = GuestbookAcl::DEFAULT_ROLE;
        }
        if (isset($resources[$controller]) || in_array($controller, $resources)) {
            if ($acl->isAllowed($role, $controller, $action)) {
                $denied = FALSE;
            }
        }
        if ($denied) {
            header('Location: /');
            exit;
        }
        // otherwise: do nothing
    }
}
