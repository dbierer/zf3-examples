<?php
namespace PrivateMessages\Controller;

use PrivateMessages\Generic\MakePrime;
use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;

class KeypairsController extends AbstractActionController
{
    public function diffieAction()
    {
        $pairs['bob']   = '69949544903862536994954490386277';
        $pairs['alice'] = '83169594039556738316959403956003';
        $pairs['prime'] = '50623442858352025062344285835211';
        return new ViewModel(['pairs' => $pairs]);
    }
}
