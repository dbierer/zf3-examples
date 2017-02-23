<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Tutorial\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class InfoController extends AbstractActionController
{

    const SUCCESS_VALID = '<b style="color:green;">SUCCESS:</b> all form data validated successfully';
    const ERROR_VALID = '<b style="color:red;">ERROR:</b> form data did not validate correctly';
    const NO_DATA = 'Please enter data as appropriate';

    protected $infoItems;
    protected $form;
    use TableTrait;

    public function indexAction()
    {
        $infoKey = $this->params()->fromRoute('infoKey');
        return new ViewModel(['infoKey' => $infoKey, 'infoItems' => $this->getInfoItems()]);
    }
    public function formAction()
    {
        $message = self::NO_DATA;
        $data = [];
        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $this->form->setData($data);
            if ($this->form->isValid()) {
                $message = self::SUCCESS_VALID;
                $data = $this->form->getData();
                $result = $this->table->save($data);
                $data[] = $result;
            } else {
                $message = self::ERROR_VALID;
            }
        }
        return new ViewModel(['form' => $this->form, 'data' => $data, 'message' => $message]);
    }
    public function setInfoItems($infoItems)
    {
        $this->infoItems = $infoItems;
    }
    public function getInfoItems()
    {
        return $this->infoItems;
    }
    /**
     * @return the $form
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * @param field_type $form
     */
    public function setForm($form)
    {
        $this->form = $form;
    }

}
