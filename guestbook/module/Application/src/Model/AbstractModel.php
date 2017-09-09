<?php
namespace Application\Model;

abstract class AbstractModel
{
    const ERROR_HYDRATE = 'ERROR: unable to hydrate this object: need either an array or stdClass object';
    protected $mapping = [];
    protected $properties = [];
    public function __construct(array $properties = NULL)
    {
        if ($properties) $this->hydrate($properties);
    }
    public function __call($method, $value)
    {
        $prefix = substr($method, 0, 3);
        $key    = str_replace('_', '', strtolower(substr($method, 3)));
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
    public function hydrate($input)
    {
        if (is_object($input)) {
            $this->properties = get_object_vars($input);
        } elseif (is_array($input)) {
            $this->properties = $input;
        } else {
            throw new InvalidArgumentException(self::ERROR_HYDRATE);
        }
        return $this;
    }
    public function extract()
    {
        $data = [];
        foreach ($this->mapping as $key => $value) {
            if (!empty($this->properties[$key])) {
                $data[$value] = $this->properties[$key];
            }
        }
        return $data;
    }
}
