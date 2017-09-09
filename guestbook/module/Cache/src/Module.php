<?php
namespace Cache;

use Zend\Mvc\MvcEvent;
use Zend\Cache\StorageFactory;
use Zend\Cache\Storage\Adapter\Filesystem;

class Module
{
    public function getServiceConfig()
    {
        return [
            'services' => [
                'cache-config' => [
                    'adapter' => [
                        'name'      => 'filesystem',
                        'options'   => ['ttl' => 3600],
                        'cache_dir' => __DIR__ . '/../../../data/cache',
                    ],
                    'plugins' => [
                        // override in /config/autoload/development.local.php
                        'exception_handler' => ['throw_exceptions' => FALSE],
                    ],
                ],
            ],
            'factories' => [
                'cache-adapter' => function ($container) {
                    return StorageFactory::factory($container->get('cache-config'));
                },
            ],
        ];
    }
}
