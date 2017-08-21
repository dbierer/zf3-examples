<?php
namespace Events\Doctrine\Controller;

trait ServiceLocatorTrait
{
    protected $serviceLocator;
    public function setServiceLocator($locator)
    {
        $this->serviceLocator = $locator;
    }
}
