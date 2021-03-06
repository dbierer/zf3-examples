<?php
namespace Guestbook\Controller;

use Guestbook\Listener\CacheAggregate;
use Guestbook\Form\Guestbook as GuestbookForm;
use Guestbook\Model\Guestbook as GuestbookModel;
use Guestbook\Mapper\Guestbook as GuestbookMapper;

use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;

class GuestbookController extends AbstractActionController
{
    
    const SUCCESS_ADD = 'Thanks for signing our guestbook!';
    const ERROR_ADD   = 'SORRY ... unable to add you to the guestbook';
    const ERROR_VALID = 'SORRY ... there was a form validation problem';
    
    protected $form;
    protected $mapper;
    public function indexAction()
    {
        return new ViewModel(['guestList' => $this->mapper->findAll()]);
    }
    public function signAction()
    {
        $post = '';
        $guest = '';
        $message = '';
        $request = $this->getRequest();
        if ($request->isPost()) {
            $post = array_merge_recursive(
                $request->getPost()->toArray(),
                $request->getFiles()->toArray()
            );
            $this->form->bind(new GuestbookModel());
            $this->form->setData($post);
            if ($this->form->isValid()) {
                $guest = $this->form->getData();
                $guest->setAvatar(basename($guest->getAvatar()['tmp_name']));
                if ($this->mapper->add($guest)) {
                    $message = self::SUCCESS_ADD;
                    // trigger event to clear cache
                    $this->getEventManager()->trigger(CacheAggregate::EVENT_CLEAR_CACHE, $this, ['entity' => $guest]);
                } else {
                    $message = self::ERROR_ADD;
                }
            } else {
                $message = self::ERROR_VALID;
            }
        }
        return new ViewModel(['form' => $this->form, 'message' => $message, 'data' => $post, 'guest' => $guest]);
    }
    public function setForm(GuestbookForm $form)
    {
        $this->form = $form;
    }
    public function setMapper(GuestbookMapper $mapper)
    {
        $this->mapper = $mapper;
    }
}
