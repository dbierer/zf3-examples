<?php
namespace Login\Controller;

use Application\Traits\FlashMessengerTrait;
use Login\Model\ {User, UsersTable};
use Login\Form\ {Login as LoginForm, Register as RegForm};

use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Authentication\AuthenticationService;

class IndexController extends AbstractActionController
{
    
    use FlashMessengerTrait;
    
    const LOGIN_INIT    = '<b style="color:gray;">Please requested login information</b>';
    const LOGIN_SUCCESS = '<b style="color:green;">Login was successful</b>';
    const LOGIN_FAIL    = '<b style="color:red;">Login failed</b>';
    const FORM_INVALID  = '<b style="color:orange;">There were invalid form entries: please review error messages</b>';
    const REG_SUCCESS   = '<b style="color:green;">Registration was successful</b>';
    const REG_FAIL      = '<b style="color:red;">Registration failed</b>';
    
    protected $table;
    protected $loginForm;
    protected $regForm;
    protected $authService;
    
    public function indexAction()
    {
        return new ViewModel(['loginForm' => $this->loginForm, 
                              'regForm' => $this->regForm,
                              'message' => '']);
    }    
    /**
     * Performs basic login / authentication
     * 
     * Additional security suggestions:
     * #1: create a log file of successful and failed login attempts
     * #2: maintain a counter and redirect at random if XXX number of failed login attempts
     * 
     */
    public function loginAction()
    {
        $message = '';
        $request = $this->getRequest();
        if ($request->isPost()) {
            $this->loginForm->bind(new User());
            $this->loginForm->setData($request->getPost());
            if (!$this->loginForm->isValid()) {
                $message = self::FORM_INVALID;
            } else {
                $user = $this->loginForm->getData();
                $adapter = $this->authService->getAdapter();
                $adapter->setIdentity($user->getEmail());
                $adapter->setCredential($user->getPassword());
                $result = $adapter->authenticate();
                if ($result->isValid()) {
                    $storage = $this->authService->getStorage();
                    $user = $adapter->getResultRowObject();
                    $storage->write(new User(get_object_vars($user)));
                    $message = self::LOGIN_SUCCESS;
                    $this->redirect()->toRoute('login');
                } else {
                    $message = self::LOGIN_FAIL . '<br>' . implode('<br>', $result->getMessages());
                }
            }
            $this->flashMessenger()->addMessage($message);
        }
        $message = $message ?: implode('<br>', $this->flashMessenger()->getMessages());
        $viewModel = new ViewModel(['loginForm' => $this->loginForm, 
                                    'regForm' => $this->regForm,
                                    'message' => $message]);
        $viewModel->setTemplate('login/index/index');
        return $viewModel;
    }
    public function logoutAction()
    {
        $this->authService->clearIdentity();
        return $this->redirect()->toRoute('login');
    }    
    public function registerAction()
    {
        $message = '';
        $request = $this->getRequest();
        if ($request->isPost()) {
            $this->regForm->bind(new User());
            $this->regForm->setData($request->getPost());
            if (!$this->regForm->isValid()) {
                $message = self::FORM_INVALID;
            } else {
                $user = $this->regForm->getData();
               if ($this->table->save($user)) {
                    $message = self::REG_SUCCESS;
                } else {
                    $message = self::REG_FAIL . '<br>' . implode('<br>', $result->getMessages());
                }
            }
        }
        $viewModel = new ViewModel(['loginForm' => $this->loginForm, 
                                    'regForm' => $this->regForm,
                                    'message' => $message]);
        $viewModel->setTemplate('login/index/index');
        return $viewModel;
    }
    public function testAction()
    {
    }
    public function setTable(UsersTable $table)
    {
        $this->table = $table;
    }
    public function setLoginForm(LoginForm $form)
    {
        $this->loginForm = $form;
    }    
    public function setRegForm(RegForm $form)
    {
        $this->regForm = $form;
    }    
    public function setAuthService(AuthenticationService $svc)
    {
        $this->authService = $svc;
    }
}
