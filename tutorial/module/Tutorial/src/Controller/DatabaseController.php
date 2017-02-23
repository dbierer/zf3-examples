<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Tutorial\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class DatabaseController extends AbstractActionController
{

    const ERROR_FIND = '<b style="color:red;">ERROR:</b> unable to locate entry';
    const ERROR_DELETE = '<b style="color:red;">ERROR:</b> unable to delete entry';
    const SUCCESS_DELETE = '<b style="color:green;">SUCCESS:</b> entry deleted successfully';

    use AdapterTrait;
    use TableTrait;

    public function queryAction()
    {
        $sql = 'SELECT * FROM tutorial';
        $id = (int) $this->params()->fromRoute('id');
        $params = [];
        if ($id) {
            $sql .= ' WHERE id = ?';
            $params[] = $id;
        }
        $result = $this->getAdapter()->query($sql, $params);
        return $this->getResultsView($result);
    }
    public function tableAction()
    {
        $id = (int) $this->params()->fromRoute('id');
        if ($id) {
            $result = $this->table->findById($id);
        } else {
            $result = $this->table->fetchAll();
        }
        return $this->getResultsView($result);
    }
    public function deleteAction()
    {
        $result = [];
        $message = '';
        $id = (int) $this->params()->fromRoute('id');
        if ($id) {
            if ($result = $this->table->findById($id)) {
                if ($this->table->removeById($id)) {
                    $message = self::SUCCESS_DELETE;
                } else {
                    $message = self::ERROR_DELETE;
                }
            } else {
                $message = self::ERROR_FIND;
            }
        } else {
            return $this->redirect()->toRoute('tutorial/database/table');
        }
        $result = $this->table->fetchAll();
        return new ViewModel(['message' => $message, 'result' => $result]);
    }
    protected function getResultsView($result)
    {
        $viewModel = new ViewModel(['result' => $result]);
        $viewModel->setTemplate('tutorial/database/results');
        return $viewModel;
    }
}
