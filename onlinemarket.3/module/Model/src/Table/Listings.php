<?php
namespace Model\Table;

use DateTime;
use DateInterval;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Where;
use Zend\Db\TableGateway\TableGateway;

class Listings extends TableGateway
{
    const TABLE_NAME = 'listings';
    public function findByCategory($category)
    {
        return $this->select(['category' => $category]);
    }
    public function findById($id)
    {
        return $this->select(['listings_id' => $id])->current();
    }
    public function findLatest()
    {
        $select = (new Sql($this->getAdapter()))->select();
        $select->from(self::TABLE_NAME)
               ->order('listings_id desc')
               ->limit(1);
        return $this->selectWith($select)->current();
    }
    public function remove($data)
    {
        if (isset($data['itemId']) && isset($data['deleteCode'])) {
            return (bool) $this->delete(['listings_id' => $data['itemId'],
                                         'delete_code' => $data['deleteCode']]);
        } else {
            return false;
        }
    }
    public function save($data)
    {
        $data['date_expires'] = $this->getDateExpires($data['expires']);
        unset($data['expires']);
        unset($data['submit']);
        unset($data['cityCode']);
        unset($data['captcha']);
        echo __METHOD__ . '<pre>:' . var_export($data, true) . '</pre>';
        return $this->insert($data);
    }
    protected function getDateExpires($expires)
    {
        $now = new DateTime();
        $now = ($expires) ? $now->add(new DateInterval('P' . (int) $expires . 'D')) : $now;
        return $now->format('Y-m-d H:i:s');
    }
}
