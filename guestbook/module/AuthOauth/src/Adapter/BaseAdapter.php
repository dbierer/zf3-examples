<?php
namespace AuthOauth\Adapter;

use Exception;
use AuthOauth\Generic\AuthServiceTrait;
use Zend\Authentication\Adapter\AbstractAdapter;

abstract class BaseAdapter extends AbstractAdapter
{
    
    use AuthServiceTrait;
    
    const SUCCESS_AUTH = 'SUCCESS: authentication was successful';
    const ERROR_AUTH = 'ERROR: authentication failure';
    const ERROR_UNKNOWN = 'ERROR: unknown: ';
    const ERROR_NO_RESPONSE = 'ERROR: no response';
    const ERROR_INVALID_STATE = 'ERROR: invalid state: ';
    const ERROR_SOMETHING_WRONG = 'ERROR: something went wrong: ';
    
    protected $userEntity;
    protected $userHydrator;
    protected $session;
    protected $callback;
    
    abstract public function setCustomInfo($entity, $response);
    abstract public function authenticate();

    public function formatErrorMessage($line, $text)
    {
        return sprintf("%s : %s : %04d : %s\n", date('Y-m-d H:i:s'), __CLASS__, $line, $text);
    }
    
    // getters and setters
    public function setUserEntity($entity)
    {
        $this->userEntity = $entity;
    }
    public function getUserEntity()
    {
        return $this->userEntity;
    }
    public function setUserHydrator($hydrator)
    {
        $this->userHydrator = $hydrator;
    }
    public function getUserHydrator()
    {
        return $this->userHydrator;
    }
    public function setSession($session)
    {
        $this->session = $session;
    }
    public function getSession()
    {
        return $this->session;
    }
    public function setCallback($callback)
    {
        $this->callback = $callback;
    }
    public function getCallback()
    {
        return $this->callback;
    }
}
