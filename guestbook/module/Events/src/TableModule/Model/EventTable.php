<?php
namespace Events\TableModule\Model;
class EventTable extends Base
{
    public static $tableName = 'event';
    public function findAll()
    {
        return $this->tableGateway->select()->toArray();
    }
    public function findById($eventId)
    {
        return $this->tableGateway->select(['id' => $eventId])->current()->getArrayCopy();
    }
}
