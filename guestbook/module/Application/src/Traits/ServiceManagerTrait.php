<?php
namespace Application\Traits;
trait ServiceManagerTrait
{
    protected $serviceManager;
    public function setServiceManager($mgr)
    {
        $this->serviceManager = $mgr;
    }
    public function getServiceManager()
    {
        return $this->serviceManager;
    }
}
