<?php
namespace PrivateMessages;

use PrivateMessages\Model\Message;
use Zend\Mvc\MvcEvent;
use Zend\Crypt\Symmetric\Exception\NotFoundException;
use Zend\Crypt\BlockCipher;

class Module
{

    const ERROR_OPENSSL = 'ERROR: the OpenSSL extension is not available on this server';
    const ERROR_ALGO    = 'ERROR: none of the preferred algorithms or modes are supported on this server';
    
    const VERSION = '3.0.3-dev';

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function onBootstrap(MvcEvent $e)
    {
        $em = $e->getApplication()->getEventManager();
        $em->attach(MvcEvent::EVENT_DISPATCH, [$this, 'resetNavigation'], 89);
    }
    
    public function resetNavigation(MvcEvent $e)
    {
        $sm = $e->getApplication()->getServiceManager();
        $authService = $sm->get('login-auth-service');
        $navigation = $sm->get('navigation');
        if (!$authService->hasIdentity()) {
            $page = $navigation->findOneBy('label', 'Messages');
            $navigation->removePage($page);
        }
    }
    
    public function getServiceConfig()
    {
        return [
            'services' => [
                'private-messages-key' => 'AXee4aivHieQuei8Ophao8Ooda7AhbiX',
                'private-messages-algos' => 
                    ['camellia-256-gcm','camellia-256-ctr','aes-256-gcm', 'aes-256-ctr'],
            ],
            'factories' => [
                'private-messages-openssl-config' => 
                    function ($container) {
                        if (!function_exists('openssl_get_cipher_methods')) {
                            error_log(__METHOD__ . ':' . self::ERROR_OPENSSL);
                            throw new NotFoundException(self::ERROR_OPENSSL);
                        }
                        $found = 0;
                        $algos = openssl_get_cipher_methods();
                        foreach ($container->get('private-messages-algos') as $supported) {
                            if (in_array($supported, $algos)) {
                                $found++;
                                break;
                            }
                        }
                        if (!$found) {
                            error_log(__METHOD__ . ':' . self::ERROR_ALGO);
                            throw new NotFoundException(self::ERROR_ALGO);
                        }
                        return explode('-', $supported);                            
                },
                'private-messages-block-cipher' => 
                    function ($container) {
                        $config = $container->get('private-messages-openssl-config');
                        $cipher = BlockCipher::factory(
                            'openssl', ['algo' => $config[0], 'mode' => $config[2]]);
                        $cipher->setKey($container->get('private-messages-key'));
                        return $cipher;
                },
            ],
        ];
    }
}
