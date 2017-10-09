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
        return new JsonModel($this->service->find($id));
    }
    public function getList()
    {
        $params = $this->params()->fromQuery() ?? [];
        if ($params) {
            $result = $this->service->search($params);
        } else {
            $result = $this->service->find();
        }
        return new JsonModel($result);
    }
    public function update($id, $data)
    {
        return new JsonModel($this->service->save($id, $data));
    }
    public function replaceList($data)
    {
        $return = [];
        $result = $this->service->add($data);
        if (is_int($result) && $result) {
            $return = ['status' => ApiService::STATUS_OK, 'id' => $result];
        } else {
            $return = ['status' => ApiService::STATUS_NOT_OK, 'message' => $result];
            $this->getResponse()->setStatusCode(500);
        }
        return JsonModel($return);
    }
    public function setService(ApiService $service)
    {
        $this->service = $service;
        return $this;
    }
}
