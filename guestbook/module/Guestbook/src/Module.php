<?php
namespace Guestbook;
use Zend\Db\Adapter\Adapter;
class Module
{
    const VERSION = '3.0.3-dev';

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
    public function getServiceConfig()
    {
        return [
            'factories' => [
                'guestbook-db-adapter' => function ($container) {
                    return new Adapter($container->get('guestbook-db-config'));
                },
            ],
        ];                    
    }
}
