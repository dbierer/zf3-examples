<?php
namespace Application\Form;

use Zend\Form\Form;
use Zend\Form\Element;
class Guestbook extends Form
{
    public function __construct()
    {
        parent::__construct(__CLASS__);
        $this->setAttributes(['method' => 'post']);
        $email = new Element\Email('email');
        $email->setLabel('Email Address');
        $this->add($email);
        $comments = new Element\Textarea('comments');
        $comments->setLabel('Comments');
        $comments->setAttributes(['rows' => 4, 'cols' => 80]);
        $this->add($comments);
        $submit = new Element\Submit('submit');
        $submit->setAttributes(['value' => 'Sign Guestbook',
                                'style' => 'color:white;background-color:green;']);
        $this->add($submit);
        return $this;
    }
}
