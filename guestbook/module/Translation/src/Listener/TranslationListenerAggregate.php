<?php
namespace Translation\Listener;

use Locale;
use Application\Traits\ServiceManagerTrait;
use Zend\Mvc\MvcEvent;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;

class TranslationListenerAggregate implements ListenerAggregateInterface
{
    use ServiceManagerTrait;
    public function attach(EventManagerInterface $e, $priority = 100)
    {
        $shared = $e->getSharedManager();
        $this->listeners[] = $shared->attach('*', MvcEvent::EVENT_DISPATCH,  [$this, 'setTranslatorLocaleFromAuth'], 99);
        $this->listeners[] = $shared->attach('*', Event::EVENT_LOCALE_USER,  [$this, 'setTranslatorLocaleFromAuth']);
        $this->listeners[] = $shared->attach('*', Event::EVENT_LOCALE_PARAM, [$this, 'setTranslatorLocaleFromParam']);
    }
    public function detach(EventManagerInterface $e, $priority = 100)
    {
        // do nothing
    }
    public function setTranslatorLocaleFromParam($e)
    {
        $locale = $e->getParam('locale') ?? Locale::getDefault();
        $this->setTranslatorLocale($locale);
    }
    public function setTranslatorLocaleFromAuth($e)
    {
        $locale = Locale::getDefault();
        $authService = $this->serviceManager->get('login-auth-service');
        if ($authService->hasIdentity()) {
            $user = $authService->getIdentity();
            $locale = $user->getLocale() ?? Locale::getDefault();
        }
        $this->setTranslatorLocale($locale);
    }
    protected function setTranslatorLocale($locale)
    {
        $translator = $this->serviceManager->get('MvcTranslator');
        $translator->setLocale($locale);
        Locale::setDefault($locale);
    }
}
