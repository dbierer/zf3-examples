<?php
namespace PrivateMessages\Traits;

use Zend\Crypt\BlockCipher;

trait BlockCipherTrait
{
    protected $blockCipher;
    public function setBlockCipher($blockCipher)
    {
        $this->blockCipher = $blockCipher;
    }
}
