<?php
namespace Application\Traits;

trait FlashMessengerTrait
{    
    public function flashMessenger()
    {
        return new class() {
            protected $file;
            public function __construct()
            {
                $this->file = __DIR__ . '/../../../../data/cache/session.txt';
            }
            public function addMessage($text)
            {
                file_put_contents($this->file, $test . PHP_EOL, FILE_APPEND);
            }
            public function getMessages()
            {
                $messages = array();
                if (file_exists($this->file)) {
                    $messages = file($this->file);
                    unlink($this->file);
                }
                return $messages;
            }
        };
    }
}
