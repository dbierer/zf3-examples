<?php
/**
 * Sets and retrieves a randomly generated series of bytes
 *
 */
namespace Market\Plugin;

use Zend\Session\Container;

class Csrf
{

    const DEFAULT_NAMESPACE = __CLASS__;
    const DEFAULT_OFFSET = 'csrf';

    protected $container = NULL;
    protected $csrf = NULL;

    public function getContainer()
    {
        if (!$this->container) {
            $this->container = new Container(self::DEFAULT_NAMESPACE);
        }
        return $this->container;
    }
    public function setCsrf()
    {
        if (function_exists('random_bytes')) {
            $csrf = bin2hex(random_bytes(16));
        } else {
            $csrf = md5(rand(0, 999999999) . date('YmdHis'));
        }
        $this->container->offsetSet(self::DEFAULT_OFFSET, $csrf);
    }
    public function getCsrf()
    {
        $csrf = $this->getContainer()->offsetGet(self::DEFAULT_OFFSET);
        $this->getContainer()->offsetUnset(self::DEFAULT_OFFSET);
        return $csrf;
    }
    public function setAndGetCsrf()
    {
        if (!$this->getContainer()->offsetExists(self::DEFAULT_OFFSET)) {
            $this->setCsrf();
        }
        return $this->getContainer()->offsetGet(self::DEFAULT_OFFSET);
    }
}
