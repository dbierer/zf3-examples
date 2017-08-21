<?php
namespace Guestbook\Mapper;

use Guestbook\Model\Guestbook as GuestbookModel;
use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Hydrator\ClassMethods;

class Guestbook
{
    const TABLE_NAME   = 'guestbook';
    protected $table;
    protected $adapter;
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $resultSet = new HydratingResultSet(new ClassMethods, new GuestbookModel);
        $this->table = new TableGateway(self::TABLE_NAME, $adapter, NULL, $resultSet);
    }
    public function findAll()
    {
        return $this->table->select();
    }
    public function add(GuestbookModel $model)
    {
        $model->unset('submit');
        return $this->table->insert($model->extract());
    }
}
