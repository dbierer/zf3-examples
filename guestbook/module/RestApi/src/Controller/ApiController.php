<?php
namespace RestApi\Controller;

use RestApi\Service\ApiService;
use Events\TableModule\Model\ {EventTable, RegistrationTable, AttendeeTable};
use Zend\View\Model\JsonModel;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\Stdlib\ {RequestInterface, ResponseInterface};

class ApiController extends AbstractRestfulController
{
    protected $service;
    public function get($id)
    {
        return new JsonModel($this->service->get($id));
    }
    public function getList()
    {
        return new JsonModel($this->service->get());
    }
    public function setService(ApiService $service)
    {
        $this->service = $service;
        return $this;
    }
}
