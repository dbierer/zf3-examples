<?php
namespace Application\Generic;

abstract class AbstractModel implements PropertyInterface
{
    protected $mapping = [];
    protected $properties = [];
    public function __construct(array $properties = NULL)
    {
        if ($properties) {
            foreach ($properties as $key => $value) {
                $this->setProperty($key, $value);
            }
        }
    }
    public function __call($method, $value)
    {
        $prefix = substr($method, 0, 3);
        $key    = $this->normalize(substr($method, 3));
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
    public function getMapping()
    {
        return $this->mapping;
    }
    public function getProperty($key)
    {
        return $this->properties[$this->normalize($key)] ?? NULL;
    }
    public function setProperty($key, $value)
    {
        $this->properties[$this->normalize($key)] = $value;
        return $this;
    }
    public function unsetProperty($key)
    {
        $key = $this->normalize($key);
        if (isset($this->properties[$key])) {
            unset($this->properties[$key]);
        }
        return $this;
    }
    protected function normalize($key)
    {
        return str_replace('_', '', strtolower($key));
    }
}
