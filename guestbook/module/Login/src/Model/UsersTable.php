<?php
namespace Login\Model;

use Application\Model\ {AbstractTable, AbstractModel};
use Login\Security\Password;
use Zend\Hydrator\ClassMethods;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\TableGateway;

class UsersTable extends AbstractTable
{

    public static $tableName = 'users';
    public static $identityCol = 'email';
    public static $passwordCol = 'password';
    public function save(AbstractModel $user)
    {
        $password = $user->getPassword();
        $user->setPassword(Password::createHash($password));
        $data = $user->extractForDatabase();
        return $this->tableGateway->insert($data);
    }
}
