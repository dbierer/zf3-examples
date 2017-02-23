<?php
namespace Market\Controller;

use Market\Plugin\Csrf;

trait CsrfTrait
{
    protected $csrf;
    public function setCsrf(Csrf $csrf)
    {
        $this->csrf = $csrf;
    }
}
