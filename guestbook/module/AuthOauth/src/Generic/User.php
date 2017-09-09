<?php
namespace AuthOauth\Generic;
/**
 * Generic User class
 * 
 * Uses magic getters / setters / __call to simulate what a User entity might provide
 * 
 */
class User
{
    public $values;
    public function __call($name, $params)
    {
        $key = strtolower(substr($name, 3));
        if (strpos($name, 'set') === 0) {
            $this->values[$key] = $params[0];
        } elseif (strpos($name, 'get') === 0) {
            return (isset($this->values[$key])) 
                    ? $this->values[$key] : NULL;
        }
    }
}
