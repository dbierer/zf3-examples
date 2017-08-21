<?php
namespace PrivateMessages\Form;

use Zend\Filter\Encrypt;

class EncryptFilter extends Encrypt
{
    public function __construct($adapter = NULL)
    {
        $this->adapter = $adapter;
    }
    public function setAdapter($options = null)
    {
        return $this;
    }
}
