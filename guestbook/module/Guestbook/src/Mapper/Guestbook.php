<?php
namespace Guestbook\Mapper;

use Guestbook\Model\Guestbook as GuestbookModel;
use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Hydrator\ClassMethods;
use Zend\Db\TableGateway\Feature\EventFeature;
use Zend\EventManager\EventManager;

class Guestbook
{

    const TABLE_NAME   = 'guestbook';
    const IDENTIFIER   = 'guestbook-mapper';
    const ADD_EVENT    = 'guestbook-mapper-add-event';
    
    protected $table;
    protected $adapter;
    protected $eventManager;
    
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->eventManager = new EventManager();
        $this->eventManager->addIdentifiers([self::IDENTIFIER]);
        $feature = new EventFeature($this->eventManager);
        $resultSet = new HydratingResultSet(new ClassMethods, new GuestbookModel);
        $this->table = new TableGateway(self::TABLE_NAME, $adapter, $feature, $resultSet);
    }
    public function findAll()
    {
        return $this->table->select();
    }
    public function add(GuestbookModel $model)
    {
        $model->unset('submit');
        $result = $this->table->insert($model->extract());
        $this->eventManager->trigger(self::ADD_EVENT, $this, ['model' => $model]);
        return $result;
    }
    public function getEventManager()
    {
        return $this->eventManager;
    }
}
