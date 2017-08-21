<?php
namespace PrivateMessages\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\HydratingResultSet;
use PrivateMessages\Hydrator\PrivateHydrator;
use Application\Model\ {AbstractModel, AbstractTable};

class MessagesTable extends AbstractTable
{
    public static $tableName = 'messages';
    protected $hydrator;
    public function setHydrator(PrivateHydrator $hydrator)
    {
        $this->hydrator = $hydrator;
    }
    public function setTableGateway(Adapter $adapter, AbstractModel $model)
    {
        $prototype = new HydratingResultSet($this->hydrator, $model);
        $this->tableGateway = new TableGateway(static::$tableName, $adapter, NULL, $prototype);
    }
    public function findMessagesSent($email)
    {
        return $this->tableGateway->select(['from_email' => $email]);
    }
    public function findMessagesReceived($email)
    {
        return $this->tableGateway->select(['to_email' => $email]);
    }
    public function save(AbstractModel $message)
    {
        $data = $this->hydrator->extract($message);
        return $this->tableGateway->insert($data);
    }
    public function setPrivateHydrator(PrivateHydrator $hydrator)
    {
        $this->privateHydrator = $hydrator;
    }
}
