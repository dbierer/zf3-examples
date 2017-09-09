<?php
namespace PrivateMessages\Form;

use Zend\Filter;
use Zend\Validator;
use Zend\Form\ {Form, Element};
use Zend\InputFilter\ {InputFilter, Input};
use Zend\Hydrator\ClassMethods;
use PrivateMessages\Traits\BlockCipherTrait;

class Send extends Form
{
    use BlockCipherTrait;   
    public function addElements()
    {
        $this->setHydrator(new ClassMethods());
        $this->setAttributes(['method' => 'post']);
        
        $fromEmail = new Element\Email('fromEmail');
        $fromEmail->setLabel('Email Address of Sender');        
        $fromEmail->setAttributes(['size' => 40, 'readonly' => 'readonly']);
        $this->add($fromEmail);
        
        $toEmail = new Element\Email('toEmail');
        $toEmail->setLabel('Email Address of Recipient');        
        $toEmail->setAttributes(['size' => 40]);
        $this->add($toEmail);
        
        $password = new Element\Textarea('message');
        $password->setLabel('Message');        
        $password->setAttributes(['cols' => 40, 'rows' => 4]);
        $this->add($password);
        
        $submit = new Element\Submit('submit');
        $submit->setAttributes(['value' => 'Send',
                                'style' => 'color:white;background-color:green;']);
        $this->add($submit);
    }

    public function addInputFilter()
    {
        $inputFilter = new InputFilter();
        
        $toEmail = new Input('toEmail');
        $toEmail->getValidatorChain()
              ->attach(new Validator\EmailAddress());
        $toEmail->getFilterChain()
              ->attach(new Filter\StringTrim())
              ->attach(new Filter\StripTags());              
        $inputFilter->add($toEmail);
        
        $fromEmail = new Input('fromEmail');
        $fromEmail->getValidatorChain()
              ->attach(new Validator\EmailAddress());
        $fromEmail->getFilterChain()
              ->attach(new Filter\StringTrim())
              ->attach(new Filter\StripTags());              
        $inputFilter->add($fromEmail);
        
        $message = new Input('message');
        $message->getValidatorChain()
              ->attach(new Validator\StringLength(['min' => 1, 'max' => 254]))
              ->attach(new Validator\NotEmpty());
        $message->getFilterChain()
              ->attach(new Filter\StringTrim())
              ->attach(new Filter\StripTags());
              //->attach(new EncryptFilter($this->blockCipher));
        $inputFilter->add($message);
        
        
        $this->setInputFilter($inputFilter);
        return $inputFilter;
    }
}
