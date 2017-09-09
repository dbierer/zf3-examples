<?php
namespace Application\Session;

use Zend\StdLib\ArrayObject;
use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\TableGateway;
use Zend\Session\Exception;
use Zend\Session\Storage\ArrayStorage;

class CustomStorage extends ArrayStorage
{
    const TABLE_NAME = 'session_storage';

    protected $table;
    protected $adapter;
    /**
     * Constructor
     *
     * Instantiates storage as an ArrayObject, allowing property access.
     * Also sets the initial request access time.
     *
     * @param Zend\Db\Adapter\Adapter $adapter
     */
    public function __construct(
        Adapter $adapter,
        $input = [],
        $flags = ArrayObject::ARRAY_AS_PROPS,
        $iteratorClass = '\\ArrayIterator') 
    {
        parent::__construct($input, $flags, $iteratorClass);
        $this->setRequestAccessTime(microtime(true));
        $this->adapter = $adapter;
        $this->table = new TableGateway(self::TABLE_NAME, $adapter);
        foreach (iterator_to_array($this->table->select()) as $obj) {
            parent::offsetSet($obj->key, unserialize($obj->value));
        }
    }
    /**
     * Destructor
     * 
     * Wipes out self::TABLE_NAME and re-inserts key/value pairs serialized
     *
     * @return void
     */
    public function __destruct()
    {
        $this->adapter->query('DELETE FROM ' . self::TABLE_NAME, Adapter::QUERY_MODE_EXECUTE);
        if ($this->count()) {
            foreach ($this as $key => $value) {
                if (!$value instanceof ArrayObject) {
                    if (is_array($value)) {
                        $value = new ArrayObject($value);
                    } else {
                        $value = new ArrayObject([$key => $value]);
                    }
                }
                $this->table->insert(['key' => $key, 'value' => serialize($value)]);
            }
        }
    }

}
