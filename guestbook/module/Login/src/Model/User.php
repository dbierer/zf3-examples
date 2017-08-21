<?php
namespace Login\Model;
use Application\Model\AbstractModel;
class User extends AbstractModel
{
    protected $mapping = [
        'id' => 'id',
        'email' => 'email',
        'username' => 'username',
        'password' => 'password',
        'securityquestion' => 'security_question',
        'securityanswer' => 'security_answer',
    ];
}
