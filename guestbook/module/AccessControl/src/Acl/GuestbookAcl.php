<?php
namespace AccessControl\Acl;

use Zend\Permissions\Acl\ 
       {Acl,
        Role\RoleInterface,
        Resource\ResourceInterface,
        Assertion\AssertionInterface};

class GuestbookAcl
{
    const DEFAULT_ROLE = 'guest';
    protected $startTime;
    protected $stopTime;
    public function __construct(\DateTime $start, \DateTime $stop)
    {
        $this->startTime = $start;
        $this->stopTime = $stop;
    }
    public function buildAcl($config)
    {
    }
}
