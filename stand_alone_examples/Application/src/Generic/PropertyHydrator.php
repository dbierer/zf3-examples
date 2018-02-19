<?php
namespace Application\Generic;

use InvalidArgumentException;

class PropertyHydrator
{

    public function hydrate(PropertyInterface $obj, $input)
    {
        if (is_object($input)) {
            $props = get_object_vars($input);
            foreach ($props as $key => $value) {
                $obj->setProperty($key, $value);
            }
        } elseif (is_array($input)) {
            foreach ($input as $key => $value) {
                $obj->setProperty($key, $value);
            }
        } else {
            throw new InvalidArgumentException(self::ERROR_HYDRATE);
        }
        return $obj;
    }

    public function extract(PropertyInterface $obj)
    {
        $data = [];
        foreach ($obj->getMapping() as $key => $value) {
            if (!empty($obj->getProperty($key))) {
                $data[$value] = $obj->getPropertiy($key);
            }
        }
        return $data;
    }

}
