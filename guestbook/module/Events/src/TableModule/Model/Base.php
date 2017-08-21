<?php
namespace Events\TableModule\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\TableGateway;

class Base
{
    public static $tableName;
    protected $tableGateway;
    public function setTableGateway(Adapter $adapter)
    {
        $this->tableGateway = new TableGateway(static::$tableName, $adapter);
    }
}
