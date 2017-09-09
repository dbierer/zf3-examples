<?php
namespace AuthOauth\Factory;

use Exception;
use Interop\Container\ContainerInterface;

// ZF 3
use Zend\ServiceManager\Factory\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

// ZF 2.4
// use Zend\ServiceManager\AbstractFactoryInterface;

class AdapterAbstractFactory implements AbstractFactoryInterface
{
    
    const ERROR_NO_CONFIG = 'ERROR: no configuration for this provider ';
    
    // ZF 3
    public function canCreate(ContainerInterface $container, $requestedName)
    {
        return $this->canCreateServiceWithName($container, NULL, $requestedName);
    }

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return $this->createServiceWithName($container, NULL, $requestedName);
    }
    
    // ZF 2.4 and below
    public function canCreateServiceWithName(
                            ServiceLocatorInterface $sm, 
                            $name, 
                            $requestedName) 
    {
        return (fnmatch('auth-oauth-adapter-*', $requestedName)) ? TRUE : FALSE;
    } 
    
    public function createServiceWithName(
                            ServiceLocatorInterface $sm, 
                            $name, 
                            $requestedName) 
    {
        // splits by either "-" or "\"
        $breakdown = preg_split('!-|\\\!', $requestedName);
        $provider  = array_pop($breakdown);
        $className = 'AuthOauth\\Adapter\\' . ucfirst($provider) . 'Adapter';
        $config    = $sm->get('auth-oauth-config');
        if (!isset($config[$provider])) {
            $message = self::ERROR_NO_CONFIG . $provider;
            throw new Exception($message);
        }
        $adapter = new $className($config[$provider]);
        $adapter->setAuthService($sm->get('auth-oauth-service'));
        $adapter->setUserEntity($sm->get('auth-oauth-user-entity'));
        $adapter->setUserHydrator($sm->get('auth-oauth-user-hydrator'));
        $adapter->setSession($sm->get('auth-oauth-session-container'));
        $adapter->setCallback($sm->get('auth-oauth-callback'));
        return $adapter;
    }
}
