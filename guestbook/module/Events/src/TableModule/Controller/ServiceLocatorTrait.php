<?php
namespace Events\TableModule\Controller;

trait ServiceLocatorTrait
{
    protected $serviceLocator;
    public function setServiceLocator($locator)
    {
        $this->serviceLocator = $locator;
    }
}
