<?php
namespace Market\Controller;

use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;

class PostController extends AbstractActionController
{

    const EVENT_NOTIFY = 'notify.event';
    const ERROR_POST = 'ERROR: unable to validate item information';
    const ERROR_SAVE = 'ERROR: unable to save item to the database';
    const SUCCESS_POST = 'SUCCESS: item posted OK';
    const DEFAULT_MSG = 'Please enter information as appropriate';

    use FlashTrait;
    use PostFormTrait;
    use ListingsTableTrait;

    public function indexAction()
    {
        $data = [];
        $message = self::DEFAULT_MSG;
        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $this->breakoutCityAndCountry($data);
            $this->postForm->setData($data);
            if ($this->postForm->isValid()) {
                if ($this->listingsTable->save($this->postForm->getData())) {
                    $this->flash->addMessage(self::SUCCESS_POST);
                    return $this->redirect()->toRoute('market');
                } else {
                    $message = self::ERROR_SAVE;
                }
            } else {
                $message = self::ERROR_POST;
            }
            $this->flash->addMessage($message);
            $notifyParams = ['subject' => $message, 'body' => __METHOD__ . PHP_EOL . date('Y-m-d H:i:s')];
            // adding an identifier to the local controller event manager is not
            // necessary as the shared event manager in the Notify::Module class uses
            // "*" to avoid having specific identifiers
            //$this->getEventManager()->addIdentifiers(['notify']);
            $this->getEventManager()->trigger(self::EVENT_NOTIFY, $this, $notifyParams);
        }
        return new ViewModel(['postForm' => $this->postForm, 'data' => $data, 'flash' => $this->flash]);
    }

    protected function breakoutCityAndCountry(&$data)
    {
        if (isset($data['cityCode']) && strpos($data['cityCode'], ','))
            list($data['city'],$data['country']) = explode(',', $data['cityCode']);
    }

}
