<?php
namespace AuthOauth\Factory;

use AuthOauth\Listener\OauthListenerAggregate;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class ListenerAggregateFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        $aggregate = new OauthListenerAggregate();
        $aggregate->setServiceManager($container);
        $aggregate->setAuthService($container->get('auth-oauth-service'));
        return $aggregate;
    }
}
