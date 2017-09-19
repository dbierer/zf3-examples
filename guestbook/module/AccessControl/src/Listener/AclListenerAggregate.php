<?php
namespace AccessControl\Listener;

use Application\Traits\ServiceManagerTrait;
use Zend\Mvc\MvcEvent;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;

class AclListenerAggregate implements ListenerAggregateInterface
{
    
    const DEFAULT_ROLE = 'guest';
    const DEFAULT_ACTION = 'index';
    const DEFAULT_CONTROLLER = 'Guestbook\Controller\GuestbookController';
    
    use ServiceManagerTrait;
    public function attach(EventManagerInterface $e, $priority = 100)
    {
        $shared = $e->getSharedManager();
        $this->listeners[] = $shared->attach('*', MvcEvent::EVENT_DISPATCH,  [$this, 'checkAcl'], 999);
        $this->listeners[] = $shared->attach('*', MvcEvent::EVENT_DISPATCH,  [$this, 'injectAcl'], 99);
    }
    public function detach(EventManagerInterface $e, $priority = 100)
    {
        // do nothing
    }
    public function injectAcl(MvcEvent $e)
    {
        $sm = $this->getServiceManager();
        $acl = $sm->get('access-control-guestbook-acl');
        $layout = $e->getViewModel();
        $layout->setVariable('acl', $acl);
    }
    public function checkAcl(MvcEvent $e)
    {
        // get ACL and auth service
        $sm = $this->getServiceManager();
        $acl = $sm->get('access-control-guestbook-acl');
        $authService = $sm->get('login-auth-service');
        // pull resource and rights from route match
        $match = $e->getRouteMatch();
        $rights = $match->getParam('action');
        $resource = $match->getParam('controller');
        // get role
        if ($authService->hasIdentity()) {
            $role = $authService->getIdentity()->getRole() ?? GuestbookAcl::DEFAULT_ROLE;
        } else {
            $role = self::DEFAULT_ROLE;
        }
        // make sure controller which is matched is in the list of resources
        $denied = TRUE;
        if ($acl->hasResource($resource) 
            && $acl->hasRole($role) 
            && $acl->isAllowed($role, $resource, $rights)) {
                    $denied = FALSE;
        }
        if ($denied && $resource != self::DEFAULT_CONTROLLER) {
            $match->setParam('controller', self::DEFAULT_CONTROLLER);
            $match->setParam('action', self::DEFAULT_ACTION);
        }
        // otherwise: do nothing
    }
}
