<?php
namespace Login\Auth;

use Zend\Authentication\Storage\StorageInterface;

class CustomStorage implements StorageInterface
{
    protected $storageFile;
    protected $contents;
    public function __construct($storageFile)
    {
        $this->storageFile = $storageFile;
    }
    /**
     * Returns true if and only if storage is empty
     *
     * @throws \Zend\Authentication\Exception\ExceptionInterface If it is impossible to determine whether storage is empty
     * @return bool
     */
    public function isEmpty()
    {
        return !file_exists($this->storageFile);
    }
    /**
     * Returns the contents of storage
     *
     * Behavior is undefined when storage is empty.
     *
     * @throws \Zend\Authentication\Exception\ExceptionInterface If reading contents from storage is impossible
     * @return mixed
     */
    public function read()
    {
        $contents = '';
        if (file_exists($this->storageFile)) {
            $contents = trim(file_get_contents($this->storageFile));
        }
        return unserialize($contents);
    }
    /**
     * Writes $contents to storage
     *
     * @param  mixed $contents
     * @throws \Zend\Authentication\Exception\ExceptionInterface If writing $contents to storage is impossible
     * @return void
     */
    public function write($contents)
    {
        file_put_contents($this->storageFile, serialize($contents));
    }
    /**
     * Clears contents from storage
     *
     * @throws \Zend\Authentication\Exception\ExceptionInterface If clearing contents from storage is impossible
     * @return void
     */
    public function clear()
    {
        if (file_exists($this->storageFile)) {
            unlink($this->storageFile);
        }
    }
}
 
