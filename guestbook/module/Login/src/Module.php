<?php
namespace Login;
use Login\Model\UsersTable;
use Login\Auth\CustomStorage;
use Zend\Mvc\MvcEvent;
use Zend\Db\Adapter\Adapter;
use Zend\Authentication\Storage\Session;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable\CallbackCheckAdapter;

class Module
{
    const VERSION = '3.0.3-dev';

    public function onBootstrap(MvcEvent $e)
    {
        $em = $e->getApplication()->getEventManager();
        $em->attach(MvcEvent::EVENT_DISPATCH, [$this, 'injectAuthService']);
        $em->attach(MvcEvent::EVENT_DISPATCH, [$this, 'resetNavigation'], 99);
    }
    
    public function injectAuthService(MvcEvent $e)
    {
        $sm = $e->getApplication()->getServiceManager();
        $layout = $e->getViewModel();
        $layout->setVariable('authService', $sm->get('login-auth-service'));
    }
    
    public function resetNavigation(MvcEvent $e)
    {
        $sm = $e->getApplication()->getServiceManager();
        $authService = $sm->get('login-auth-service');
        $navigation = $sm->get('navigation');
        if ($authService->hasIdentity()) {
            $page = $navigation->findOneBy('label', 'Login');
            $navigation->removePage($page);
        } else {
            $page = $navigation->findOneBy('label', 'Logout');
            $navigation->removePage($page);
        }
    }
    
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
    
    public function getServiceConfig()
    {
        return [
            'factories' => [
                'login-db-adapter' => function ($container) {
                    return new Adapter($container->get('local-db-config'));
                },
                'login-auth-adapter' => function ($container) {
                    return new CallbackCheckAdapter(
                        $container->get('login-db-adapter'),
                        UsersTable::$tableName,
                        UsersTable::$identityCol,
                        UsersTable::$passwordCol,
                        function ($hash, $password) { 
                            if (strlen($hash) == 32) return $hash == md5($password);
                            else return \Login\Security\Password::verify($password, $hash); 
                        });
                },
                'login-auth-storage' => function ($container) {
                    return new CustomStorage($container->get('login-storage-filename'));
                },
                'login-auth-service' => function ($container) {
                    return new AuthenticationService(
                        $container->get('login-auth-storage'),
                        $container->get('login-auth-adapter'));
                },
            ],
        ];
    }
}
