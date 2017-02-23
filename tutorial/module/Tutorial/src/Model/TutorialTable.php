<?php
namespace Tutorial\Model;

use Exception;
use Zend\Db\TableGateway\TableGateway;

class TutorialTable extends TableGateway
{

    const TABLE_NAME = 'tutorial';
    const ERROR_INSERT = '<b style="color:red;">ERROR:</b> unable to add data';
    const ERROR_FIND = '<b style="color:red;">ERROR:</b> unable to find this entry';

    public function fetchAll()
    {
        return $this->select();
    }
    public function findById($id)
    {
        return $this->select(['id' => $id]);
    }
    public function removeById($id)
    {
        return $this->delete(['id' => $id]);
    }
    public function save($data)
    {
        $insert['name'] = $data['name'] ?? NULL;
        $insert['email'] = $data['email'] ?? NULL;
        if ($this->insert($insert)) {
            return $this->findById($this->getLastInsertValue());
        } else {
            throw new Exception(self::ERROR_INSERT);
        }
    }
}
