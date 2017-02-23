<?php
/**
 * Provides a replace for the old flashMessenger plugin
 *
 */
namespace Market\Plugin;

use Zend\Session\Container;

class Flash
{

    const DEFAULT_NAMESPACE = __CLASS__;
    const DEFAULT_OFFSET = 'messages';

    protected $container = NULL;
    public function getContainer()
    {
        if (!$this->container) {
            $this->container = new Container(self::DEFAULT_NAMESPACE);
        }
        return $this->container;
    }
    public function hasMessages()
    {
        return $this->getContainer()->offsetExists(self::DEFAULT_OFFSET);
    }
    public function addMessage($message)
    {
        $messages = $this->getContainer()->offsetGet(self::DEFAULT_OFFSET);
        $messages[] = $message;
        $this->container->offsetSet(self::DEFAULT_OFFSET, $messages);
    }
    public function getMessages()
    {
        $messages = [];
        if ($this->hasMessages()) {
            $messages = $this->getContainer()->offsetGet(self::DEFAULT_OFFSET);
            $this->getContainer()->offsetUnset(self::DEFAULT_OFFSET);
        }
        return $messages;
    }
}
