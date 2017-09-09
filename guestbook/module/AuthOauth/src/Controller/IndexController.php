<?php
namespace AuthOauth\Controller;

use AuthOauth\Adapter\GoogleAdapter;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    use AuthServiceTrait;
    protected $authAdapterGoogle;
    public function indexAction()
    {
        if ($this->authService->hasIdentity()) {
            $message = 'Login Identity:';
            $result = $this->authService->getIdentity();
        } else {
            $message = 'Login Failure';
            $result = NULL;
        }
        $viewModel = new ViewModel(['action' => $message, 'result' => $result]);
        $viewModel->setTemplate('auth-oauth/index/result');
        return $viewModel;
    }
    public function googleAction()
    {
        // provide auth service argument to have authenticate() store identity
        $result = $this->authAdapterGoogle->authenticate($this->authService);
        $viewModel = new ViewModel(['action' => 'Google', 'result' => $result]);
        $viewModel->setTemplate('auth-oauth/index/result');
        return $viewModel;
    }
    public function setAuthAdapterGoogle(GoogleAdapter $adapter)
    {
        $this->authAdapterGoogle = $adapter;
    }
}
