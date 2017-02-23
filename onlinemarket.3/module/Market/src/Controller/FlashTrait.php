<?php
namespace Market\Controller;

use Market\Plugin\Flash;

trait FlashTrait
{
    protected $flash;
    public function setFlash(Flash $flash)
    {
        $this->flash = $flash;
    }
}
