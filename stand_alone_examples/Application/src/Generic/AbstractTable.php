<?php
namespace Application\Generic;

use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\TableGateway;

abstract class AbstractTable
{
    protected $tableGateway;
    public function setTableGateway(Adapter $adapter, AbstractModel $model)
    {
        $prototype = new HydratingResultSet(new PropertyHydrator(), $model);
        $this->tableGateway = new TableGateway(static::$tableName, $adapter, NULL, $prototype);
    }
    abstract public function save(PropertyInterface $model);
}
