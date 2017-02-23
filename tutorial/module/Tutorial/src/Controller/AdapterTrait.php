<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Tutorial\Controller;

use Zend\Db\Adapter\Adapter;

trait AdapterTrait
{
    protected $adapter;
    public function setAdapter(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }
    public function getAdapter()
    {
        return $this->adapter;
    }
}
