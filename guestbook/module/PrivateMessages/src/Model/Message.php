<?php
namespace PrivateMessages\Model;
use Application\Model\AbstractModel;
class Message extends AbstractModel
{ 
    protected $id;
    protected $toEmail;
    protected $fromEmail;
    protected $message;
    protected $mapping = ['id' => 'id', 'toEmail' => 'to_email', 'fromEmail' => 'from_email', 'message' => 'message'];
    public function __construct(array $data = NULL)
    {
        $this->setId($data['id'] ?? NULL);
        $this->setToEmail($data['to_email'] ?? NULL);
        $this->setFromEmail($data['from_email'] ?? NULL);
        $this->setMessage($data['message'] ?? NULL);
        return $this;
    }
    public function setToEmail($email)
    {
        $this->toEmail = $email;
        return $this;
    }
    public function getToEmail()
    {
        return $this->toEmail;
    }
    public function setFromEmail($email)
    {
        $this->fromEmail = $email;
        return $this;
    }
    public function getFromEmail()
    {
        return $this->fromEmail;
    }
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }
    public function getMessage()
    {
        return $this->message;
    }
    public function extract()
    {
        $data = [];
        foreach (get_object_vars($this) as $key => $value) {
            if (isset($this->mapping[$key])) {
                $data[$this->mapping[$key]] = $value;
            }
        }
        return $data;
    }
}
