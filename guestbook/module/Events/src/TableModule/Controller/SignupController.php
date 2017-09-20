<?php
namespace Events\TableModule\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Filter;

class SignupController extends AbstractActionController
{
    use TableTrait;
    protected $regDataFilter;
    public function indexAction()
    {
        $eventId = (int) $this->params('event');
        if ($eventId) {
            return $this->eventSignup($eventId);
        }
        $events = $this->eventTable->findAll();
        return new ViewModel(array('events' => $events));
    }

    public function thanksAction()
    {
        return new ViewModel();
    }

    protected function eventSignup($eventId)
    {
        $event = $this->eventTable->findById($eventId);
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
        $regId = $this->registrationTable->persist($eventId, $formData['first_name'], $formData['last_name']);
        $ticketData = $formData['ticket'];
        foreach ($ticketData as $nameOnTicket) {
            $this->attendeeTable->persist($regId, $nameOnTicket);
        }
        return true;
    }

    protected function sanitizeData(array $data)
    {
        $clean  = array();
        foreach ($data as $key => $item) {
            if (is_array($item)) {
                foreach ($item as $subKey => $subItem) {
                    $clean[$key][$subKey] = $this->regDataFilter->filter($subItem);
                }
            } else {
                $clean[$key] = $this->regDataFilter->filter($item);
            }
        }
        return $clean;
    }

    public function setRegDataFilter($filter)
    {
        $this->regDataFilter = $filter;
    }
}
