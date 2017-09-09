<?php
namespace AuthOauth\Controller;

use Zend\Authentication\AuthenticationService;
trait AuthServiceTrait
{
    protected $authService;
    public function setAuthService(AuthenticationService $service)
    {
        $this->authService = $service;
    }
}
