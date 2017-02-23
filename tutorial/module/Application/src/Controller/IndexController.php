<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $firstName = 'Fred';
        $lastName = 'Flintstone';
        return new ViewModel(['firstName' => $firstName, 'lastName' => $lastName]);
    }
    public function anotherAction()
    {
        $firstName = 'Fred';
        $lastName = 'Flintstone';
        $viewModel = new ViewModel();
        $viewModel->setVariable('firstName', $firstName);
        $viewModel->setVariable('lastName',$lastName);
        return $viewModel;
    }
}
