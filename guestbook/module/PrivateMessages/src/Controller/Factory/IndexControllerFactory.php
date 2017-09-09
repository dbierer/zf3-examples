<?php
namespace PrivateMessages\Controller\Factory;

use PrivateMessages\Controller\IndexController;
use PrivateMessages\Form\Send as SendForm;
use PrivateMessages\Model\ {Message, MessagesTable};

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;


class IndexControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        $controller = new IndexController();
        $controller->setTable($container->get(MessagesTable::class));
        $controller->setSendForm($container->get(SendForm::class));
        $controller->setAuthService($container->get('login-auth-service'));
        $controller->setSessionContainer($container->get('application-session-container'));
        //$controller->setBlockCipher($container->get('private-messages-block-cipher'));
        return $controller;
    }
}
