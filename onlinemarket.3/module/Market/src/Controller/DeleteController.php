<?php
namespace Market\Controller;

use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;

class DeleteController extends AbstractActionController
{

    const SUCCESS_DELETE = 'SUCCESS: item deleted';
    const ERROR_CANCEL   = 'ERROR: operation cancelled';
    const ERROR_DELETE   = 'ERROR: unable to delete this item';
    const ERROR_CSRF     = 'ERROR: form data is not valid';

    use CsrfTrait;
    use FlashTrait;
    use DeleteFormTrait;
    use ListingsTableTrait;

    public function indexAction()
    {
        $itemId = (int) $this->params()->fromRoute('itemId');
        $item = $this->listingsTable->findById($itemId);
        $this->deleteForm->setAttribute('action', '/market/delete/process');
        $this->deleteForm->get('itemId')->setAttribute('value', $itemId);
        // store random CSRF value in session (see Market\Plugin\Csrf) and set value into hidden form element
        $this->deleteForm->get('noBots')->setAttribute('value', $this->csrf->setAndGetCsrf());
        return new ViewModel(['item' => $item, 'deleteForm' => $this->deleteForm]);
    }

    public function processAction()
    {
        $itemId = 0;
        if (!$this->getRequest()->isPost()) {
            $this->flash->addMessage(self::ERROR_DELETE);
        } else {
            $rawData = $this->params()->fromPost();
            if (isset($rawData['cancel'])) {
                $this->flash->addMessage(self::ERROR_CANCEL);
            } else {
                $this->deleteForm->setData($rawData);
                $this->deleteForm->isValid();
                $data = $this->deleteForm->getData();
                if ($data['noBots'] == $this->csrf->getCsrf()) {
                    if ($this->listingsTable->remove($data)) {
                        $this->flash->addMessage(self::SUCCESS_DELETE);
                    } else {
                        $this->flash->addMessage(self::ERROR_DELETE);
                    }
                } else {
                    $this->flash->addMessage(self::ERROR_CSRF);
                }
            }
            return $this->redirect()->toRoute('market');
        }
    }

    protected function getDeepMessages($form)
    {
        foreach ($this->deleteForm->getInputFilter()->getInvalidInput() as $input) {
            foreach ($input->getValidatorChain()->getValidators() as $chain) :
                foreach ($chain as $validator) :
                    if ($validator && is_object($validator)) :
                        $error = $validator->getMessages();
                        yield implode(',', $error);
                    endif;
                endforeach;
            endforeach;
        }
    }
}
