<?php
namespace PrivateMessages\Model;

use Application\Model\ {AbstractModel, AbstractTable};

class MessagesTable extends AbstractTable
{
    public static $tableName = 'messages';
    public function findMessagesSent($email)
    {
        return $this->tableGateway->select(['from_email' => $email]);
    }
    public function findMessagesReceived($email)
    {
        return $this->tableGateway->select(['to_email' => $email]);
    }
    public function save(AbstractModel $message)
    {
        $data = $message->extractForDatabase();
        return $this->tableGateway->insert($data);
    }
}
