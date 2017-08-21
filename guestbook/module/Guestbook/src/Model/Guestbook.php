<?php
namespace Guestbook\Model;

use Zend\Db\TableGateway\TableGateway;
class Guestbook
{
    const ERROR_METHOD = 'ERROR: method not found';
    const TABLE_NAME   = 'guestbook';
    protected $tableGateway;
    protected $properties = [
        'id' => '',
        'name' => '',
        'email' => '',
        'website' => '',
        'message' => '',
        'avatar' => '',
    ];
    public function __construct($properties = array())
    {
        $this->properties = $properties;
    }
    public function __call($method, $value)
    {
        $prefix = substr($method, 0, 3);
        $key    = strtolower(substr($method, 3));
        if ($prefix == 'get') {
            $result = $this->properties[$key] ?? NULL;
        } elseif ($prefix == 'set') {
            $this->properties[$key] = $value[0];
            $result = $this;
        } else {
            $result = NULL;
        }
        return $result;
    }
    public function unset($key)
    {
        if (isset($this->properties[$key])) {
            unset($this->properties[$key]);
        }
        return $this;
    }
    public function extract()
    {
        return $this->properties;
    }
}
