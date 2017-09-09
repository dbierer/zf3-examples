<?php
namespace Login;

use Login\Model\UsersTable;

use Zend\Mvc\MvcEvent;
use Zend\Db\Adapter\Adapter;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable\CallbackCheckAdapter;

class Module
{
    const VERSION = '3.0.3-dev';

    public function onBootstrap(MvcEvent $e)
    {
        $em = $e->getApplication()->getEventManager();
        $em->attach(MvcEvent::EVENT_DISPATCH, [$this, 'injectAuthService'], 999);
    }
    
    public function injectAuthService(MvcEvent $e)
    {
        $sm = $e->getApplication()->getServiceManager();
        $layout = $e->getViewModel();
        $layout->setVariable('authService', $sm->get('login-auth-service'));
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
                'login-auth-service' => function ($container) {
                    return new AuthenticationService();
                },
            ],
        ];
    }
}
