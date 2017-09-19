<?php
namespace Manage\Service;

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\TableGateway;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class GuestbookFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $service = new Guestbook();
        $adapter = new Adapter($container->get('db-config'));
        $table   = new TableGateway('guestbook', $adapter);
        $service->setTable($table);
        return $service;
    }
}
