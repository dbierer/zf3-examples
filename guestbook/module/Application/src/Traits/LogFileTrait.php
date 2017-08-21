<?php
namespace Application\Traits;
trait LogFileTrait
{
    protected $logFile;
    public function setLogFileName($path, $fn)
    {
        $this->logFile = str_replace('//', '/', $path . '/' . $fn);
    }
}
