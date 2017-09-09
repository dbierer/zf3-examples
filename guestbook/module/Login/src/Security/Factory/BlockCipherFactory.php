<?php
namespace Login\Security\Factory;

use Zend\Crypt\BlockCipher;
use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class BlockCipherFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        return BlockCipher::factory($container->get('login-block-cipher-config'));
    }
}
