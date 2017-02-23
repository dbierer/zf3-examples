<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Tutorial\Controller;

use Zend\Db\TableGateway\TableGateway;

trait TableTrait
{
    protected $table;
    public function setTable(TableGateway $table)
    {
        $this->table = $table;
    }
    public function getTable()
    {
        return $this->table;
    }
}
