<?php
namespace Events\TableModule\Controller;

use Events\TableModule\Model\ {EventTable, RegistrationTable, AttendeeTable};
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class AdminController extends AbstractActionController implements ServiceLocatorAwareInterface
{
    use ServiceLocatorTrait;

    public function indexAction()
    {
        $eventId = $this->params('event');
        if ($eventId) {
            return $this->listRegistrations($eventId);
        }
        $eventTable = $this->serviceLocator->get(EventTable::class);
        $events = $eventTable->findAll();
        $viewModel = new ViewModel(array('events' => $events));
        return $viewModel;
    }

    protected function listRegistrations($eventId)
    {
        $regTable = $this->serviceLocator->get(RegistrationTable::class);
        $registrations = $regTable->findAllForEvent($eventId);
        $viewModel = new ViewModel(array('registrations' => $registrations));
        $viewModel->setTemplate('events/table-module/admin/list.phtml');
        return $viewModel;
    }
}
