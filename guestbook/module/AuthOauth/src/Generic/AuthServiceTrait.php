<?php
namespace AuthOauth\Generic;

trait AuthServiceTrait
{    
    protected $authService;
    public function setAuthService($service)
    {
        $this->authService = $service;
    }
    public function getAuthService()
    {
        return $this->authService;
    }
}
