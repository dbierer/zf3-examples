<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Application\Traits\LogFileTrait;
use Application\Event\AppEvent;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    use LogFileTrait;
    public function indexAction()
    {
        return new ViewModel();
    }
    public function triggerLazyAction()
    {
        $em = $this->getEvent()->getApplication()->getEventManager();
        $em->trigger(AppEvent::EVENT_LOG, $this, ['message' => __METHOD__]);
        return new ViewModel(['logFile' => $this->logFile]);
    }
    public function triggerFilterAction()
    {
        $message = 'This message contains 1111-2222-3333-4444 which is a sensitive credit card number';
        $em = $this->getEvent()->getApplication()->getEventManager();
        $em->trigger(AppEvent::EVENT_LOG_FILTER, $this, ['message' => $message]);
        $viewModel = new ViewModel(['logFile' => $this->logFile]);
        $viewModel->setTemplate('application/index/trigger-lazy');
        return $viewModel;
    }
}
