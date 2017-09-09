<?php
namespace RestApi\Service;

use Zend\Db\Sql\Sql;

class ApiService
{
    
    use TableTrait;
    
    public function getSelect()
    {
        $sql = new Sql($this->eventTable->getTableGateway()->getAdapter());
        return $sql->select();
    }
    public function get($id = NULL)
    {
        $select = $this->getSelect();
        $select->from(['e' => EventTable::$tableName])
               ->join(['r' => RegistrationTable::$tableName], 'e.id = r.event_id')
               ->join(['a' => AttendeeTable::$tableName], 'r.id = a.registration_id');
        if ($id) {
            $select->where(['e.id' => $id]);
        }
        return $this->eventTable->getTableGateway()->selectWith($select)->toArray();
    }               
}
