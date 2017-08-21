<?php
namespace Events\TableModule\Controller;

use Events\TableModule\Model\ {EventTable, RegistrationTable, AttendeeTable};
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Filter;

class SignupController extends AbstractActionController implements ServiceLocatorAwareInterface
{
    use ServiceLocatorTrait;
    public function indexAction()
    {
        $eventId = (int) $this->params('event');
        if ($eventId) {
            return $this->eventSignup($eventId);
        }
        $eventTable = $this->serviceLocator->get(EventTable::class);
        $events = $eventTable->findAll();
        return new ViewModel(array('events' => $events));
    }

    public function thanksAction()
    {
        return new ViewModel();
    }

    protected function eventSignup($eventId)
    {
        $eventTable = $this->serviceLocator->get(EventTable::class);
        $event = $eventTable->findById($eventId);
        if (!$event) {
            return $this->notFoundAction();
        }
        $vm = new ViewModel(array('event' => $event));
        if ($this->request->isPost()) {
            $this->processForm($this->params()->fromPost(), $eventId);
            $vm->setTemplate('events/table-module/signup/thanks.phtml');
        } else {
            $vm->setTemplate('events/table-module/signup/form.phtml');
        }
        return $vm;
    }

    protected function processForm(array $formData, $eventId)
    {
        $formData = $this->sanitizeData($formData);
        $regTable = $this->serviceLocator->get(RegistrationTable::class);
        $attendeeTable = $this->serviceLocator->get(AttendeeTable::class);
        $regId = $regTable->persist($eventId, $formData['first_name'], $formData['last_name']);
        $ticketData = $formData['ticket'];
        foreach ($ticketData as $nameOnTicket) {
            $attendeeTable->persist($regId, $nameOnTicket);
        }
        return true;
    }

    protected function sanitizeData(array $data)
    {
        $filter = $this->serviceLocator->get('events-reg-data-filter');
        $clean  = array();
        foreach ($data as $key => $item) {
            if (is_array($item)) {
                foreach ($item as $subKey => $subItem) {
                    $clean[$key][$subKey] = $filter->filter($subItem);
                }
            } else {
                $clean[$key] = $filter->filter($item);
            }
        }
        return $clean;
    }

}
