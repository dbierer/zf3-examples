<?php
namespace PrivateMessages\Model;
use Application\Model\AbstractModel;
class Message extends AbstractModel
{ 
    protected $mapping = [
        'id' => 'id',
        'toemail' => 'to_email',
        'fromemail' => 'from_email',
        'message' => 'message',
    ];
}
