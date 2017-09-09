<?php
namespace AuthOauth\Generic;
/**
 * Generic Hydrator class
 * 
 * Designed to be used with AuthOauth\Generic\User
 * but will work with other entity classes via the Reflection hydrator
 * 
 */
use AuthOauth\Generic\User;

// ZF 2.4
// use Zend\Stdlib\Hydrator\HydratorInterface;
// use Zend\Stdlib\Hydrator\Reflection;

// ZF 3
use Zend\Hydrator\HydratorInterface;
use Zend\Hydrator\Reflection;

class Hydrator implements HydratorInterface
{
    
    /**
     * Hydrate $object with the provided $data.
     *
     * @param  array $data
     * @param  object $object
     * @return object
     */
    public function hydrate(array $data, $object)
    {
        if ($object instanceof User) {
            $object->values = $data;
        } else {
            $object = (new Reflection())->hydrate($data, $object);
        }
        return $object;
    }
    /**
     * Extract values from an object
     *
     * @param  object $object
     * @return array
     */
    public function extract($object)
    {
        if ($object instanceof User) {
            $values = $object->values;
        } else {
            $values = (new Reflection())->extract($object);
        }
        return $values;
    }
}
