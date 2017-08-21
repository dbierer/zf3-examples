<?php
namespace Events\Doctrine\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController implements RepoAwareInterface
{
    use RepoTrait;
    
    public function indexAction()
    {
        return new ViewModel();
    }
}
