<?php
namespace PrivateMessages\Controller;

use Application\Traits\FlashMessengerTrait;
use PrivateMessages\Form\Send as SendForm;
use PrivateMessages\Traits\BlockCipherTrait;
use PrivateMessages\Model\ {Message, MessagesTable};

use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Authentication\AuthenticationService;

class IndexController extends AbstractActionController
{
    
    use FlashMessengerTrait;
    
    const FORM_INVALID  = '<b style="color:orange;">There were invalid form entries: please review error messages</b>';
    const SEND_SUCCESS   = '<b style="color:green;">Message sent successfully</b>';
    const SEND_FAIL      = '<b style="color:red;">Unable to send message</b>';
    const SEND_START     = '<b style="color:gray;">Press "SEND" when ready to send a new message</b>';

    protected $table;
    protected $sendForm;
    protected $authService;
    protected $message;
    
    public function indexAction()
    {
        if (!$this->authService->hasIdentity()) {
            return $this->redirect()->toRoute('home');
        } else {
            $user = $this->authService->getIdentity();
        }        
        $from = $this->sendForm->get('fromEmail');
        $from->setAttribute('value', $user->getEmail());
        return $this->setViewModel($user, implode('<br>', $this->flashMessenger()->getMessages()));
    }    
    public function sendAction()
    {
        if (!$this->authService->hasIdentity()) {
            return $this->redirect()->toRoute('home');
        } else {
            $user = $this->authService->getIdentity();
        }
        $status = self::SEND_START;
        $request = $this->getRequest();
        if ($request->isPost()) {
            $this->sendForm->bind(new Message());
            $this->sendForm->setData($request->getPost());
            if (!$this->sendForm->isValid()) {
                $status = self::FORM_INVALID;
            } else {
                $message = $this->sendForm->getData();
                //$message->setMessage($this->blockCipher->encrypt($message->getMessage()));
                if ($this->table->save($message)) {
                    $status = self::SEND_SUCCESS;
                    $this->redirect()->toRoute('messages');
                } else {
                    $status = self::SEND_FAIL . '<br>' . implode('<br>', $result->getMessages());
                }
            }
        }
        $this->flashMessenger()->addMessage($status);
        return $this->setViewModel($user, $status);
    }
    protected function setViewModel($user, $status)
    {
        $viewModel = new ViewModel(['sendForm' => $this->sendForm,
                              'sentMessages' => $this->table->findMessagesSent($user->getEmail()),
                              'receivedMessages' => $this->table->findMessagesReceived($user->getEmail()),
                              'status' => $status,
                              //'blockCipher' => $this->blockCipher,
                              'identity' => $this->authService->getIdentity()]);
        $viewModel->setTemplate('private-messages/index/index');
        return $viewModel;
    }
    public function setTable(MessagesTable $table)
    {
        $this->table = $table;
    }
    public function setSendForm(SendForm $form)
    {
        $this->sendForm = $form;
    }    
    public function setAuthService(AuthenticationService $svc)
    {
        $this->authService = $svc;
    }
}
