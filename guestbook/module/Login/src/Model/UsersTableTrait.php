<?php
namespace Login\Model;

trait UsersTableTrait
{
    protected $table;
    public function setTable(UsersTable $table)
    {
        $this->table = $table;
    }
}
