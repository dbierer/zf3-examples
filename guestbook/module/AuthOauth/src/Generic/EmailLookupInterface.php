<?php
namespace AuthOauth\Generic;
interface EmailLookupInterface
{
    public function findByEmail($email);
}
