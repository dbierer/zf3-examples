<?php
namespace Application\Form;

use Zend\Form\Element;
class Sign
{
    public function init()
    {
        $email = new Element\Email('email');
        $email->setLabel('Email Address');
        $this->add($email);
        $comments = new Element\Textarea('comments');
        $comments->setLabel('Comments');
        $comments->setAttributes(['rows' => 4, 'cols' => 80]);
        $this->add($comments);
        $submit = new Element\Submit('submit');
        $submit->setAttributes(['value' => 'Sign Guestbook']);
        $this->add($submit);
        return $this;
    }
}
