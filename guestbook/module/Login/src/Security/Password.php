<?php
namespace Login\Security;

use Zend\Crypt\Password\Bcrypt;

class Password
{
    public static function createHash($plainText)
    {
        $bcrypt = new Bcrypt();
        return $bcrypt->create($plainText);
    }
    public static function verify($plainText, $hash)
    {
        $bcrypt = new Bcrypt();
        return $bcrypt->verify($plainText, $hash);
    }
}
