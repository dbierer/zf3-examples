<?php
namespace Events\Doctrine\Controller;

interface ServiceLocatorAwareInterface
{
    public function setServiceLocator($locator);
}
