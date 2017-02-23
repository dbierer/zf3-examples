<?php
namespace Tutorial;

// autoloading: add an entry for this namespace : src dir in composer.json :: psr-4
// activate the module: add module namespace to config/modules.config.php

use Zend\Form\Factory;

class Module
{
    // define getConfig() which returns the contents of config/module.config.php
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
}
