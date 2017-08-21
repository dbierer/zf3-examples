<?php
namespace Application\Event\Listener;
use Application\Traits\LogFileTrait;
use Application\Event\AppEvent;
class ErrorLog
{
    use LogFileTrait;
    public function logMessage($e)
    {
        $whoTriggered = get_class($e->getTarget());
        $optMessage   = $e->getParam('message') ?? 'No Message';
        $fullMessage  = '[' . date('d-M-Y H:i:s') . ']  | ' . $whoTriggered . ' | ' . $optMessage . PHP_EOL;
        file_put_contents($this->logFile, $fullMessage, FILE_APPEND);
    }
}
