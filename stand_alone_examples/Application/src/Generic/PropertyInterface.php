<?php
namespace Application\Generic;

interface PropertyInterface
{
    public function getMapping();
    public function getProperty($key);
    public function setProperty($key,$value);
    public function unsetProperty($key);
}
