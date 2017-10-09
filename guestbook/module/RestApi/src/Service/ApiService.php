<?php
namespace RestApi\Service;

use Events\TableModule\Model\ {EventTable, RegistrationTable, AttendeeTable};
use Zend\Db\Sql\ {Sql, Where};

class ApiService
{

    const STATUS_OK     = 'SUCCESS: OK';
    const STATUS_NOT_OK = 'ERROR: Not OK';

    protected $identifiers = [
        'id'               => 'id',
        'name'             => 'name',
        'max_attendees'    => 'max_attendees',
        'date'             =>'date',
        'event_id'         =>'event_id',
        'first_name'       =>'first_name',
        'last_name'        =>'last_name',
        'registration_time'=>'registration_time',
        'registration_id'  =>'registration_id',
        'name_on_ticket'   =>'name_on_ticket',
    ];
    use TableTrait;

    public function getSelect()
    {
        $sql = new Sql($this->eventTable->getTableGateway()->getAdapter());
        $select = $sql->select();
        $select->from(['e' => EventTable::$tableName])
               ->join(['r' => RegistrationTable::$tableName], 'e.id = r.event_id')
               ->join(['a' => AttendeeTable::$tableName], 'r.id = a.registration_id');
        return $select;
    }

    public function find($id = NULL)
    {
        $id = (int) $id;
        $select = $this->getSelect();
        if ($id) {
            $where = new Where();
            $where->equalTo('e.id', $id);
            $select->where($where);
        }
        return $this->eventTable->getTableGateway()->selectWith($select)->toArray();
    }
    public function search(array $params)
    {
        $condition = 0;
        $select = $this->getSelect();
        $where = new Where();
        foreach ($params as $key => $value) {
            if (isset($this->identifiers[$key])) {
                $where->like($key, '%' . $value . '%');
                $condition++;
            }
        }
        if ($condition) $select->where($where);
        return $this->eventTable->getTableGateway()->selectWith($select)->toArray();
    }
    public function add($data)
    {
        try {
            $this->eventTable->getTableGateway()->insert($data);
            $result = $this->eventTable->getTableGateway()->getLastInsertId();
        } catch (Exception $e) {
            $result = $e->getMessage();
        }
        return $result;
    }
    public function save($id, $data)
    {
        try {
            $result = $this->eventTable->getTableGateway()->update(['id' => $id], $data);
        } catch (Exception $e) {
            $result = $e->getMessage();
        }
        return $result;
    }
}
