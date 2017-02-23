<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Tutorial\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $firstName = $this->params()->fromRoute('firstName');
        $lastName = $this->params()->fromRoute('lastName');
        $viewModel = new ViewModel(['firstName' => $firstName, 'lastName' => $lastName]);
        //$viewModel->setTerminal(true);
        return $viewModel;
    }
    public function googleAction()
    {
        // redirect to google
        return $this->redirect()->toUrl('http://google.com/');
    }
    public function homeAction()
    {
        // redirect "home"
        $response = $this->getResponse();
        $response->setContent('<h1>Do Not Panic ... Everything is Under Control</h1><br>' . get_class($response));
        return $response;
        //return $this->redirect()->toRoute('home');
    }
}
