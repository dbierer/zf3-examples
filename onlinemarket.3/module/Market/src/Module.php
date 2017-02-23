<?php
namespace Market;

use Zend\Mvc\MvcEvent;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $eventManager->attach(MvcEvent::EVENT_DISPATCH, [$this, 'injectCategories']);
    }
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
    public function injectCategories(MvcEvent $e)
    {
        $viewModel = $e->getViewModel();
        $serviceManager = $e->getApplication()->getServiceManager();
        $viewModel->setVariable('categories', $serviceManager->get('market-categories'));
    }
}
