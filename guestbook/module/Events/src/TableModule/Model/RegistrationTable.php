<?php
namespace Events\TableModule\Model;
use Zend\Db\Sql\Sql;
class RegistrationTable extends Base
{
    public static $tableName = 'registration';
    // produces this SQL statement:
    // SELECT `r`.*, `a`.* FROM `registration` AS `r` 
    // INNER JOIN `attendee` AS `a` 
    // ON `a`.`registration_id` = `r`.`id` WHERE `r`.`event_id` = '{$eventId}'
    public function findAllForEvent($eventId)
    {
        $sql = new Sql($this->tableGateway->getAdapter());
        $select = $sql->select();
        $select->from(['r' => RegistrationTable::$tableName])
               ->join(['a' => AttendeeTable::$tableName],
                       'a.registration_id = r.id')
               ->where(['r.event_id' => $eventId]);
        // echo __METHOD__ . ' : ' . $sql->buildSqlString($select); exit;
        return $this->tableGateway->selectWith($select)->toArray();
    }
    public function persist($eventId, $firstName, $lastName)
    {
        $this->tableGateway->insert(
            ['event_id' => $eventId,
             'first_name' => $firstName,
             'last_name' => $lastName,
             'registration_time' => date('Y-m-d H:i:s')
             ]
        );
        return $this->tableGateway->getLastInsertValue();
    }
}
