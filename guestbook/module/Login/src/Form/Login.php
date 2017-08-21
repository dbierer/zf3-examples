<?php
namespace Login\Form;

use Zend\Filter;
use Zend\Validator;
use Zend\Form\ {Form, Element};
use Zend\InputFilter\ {InputFilter, Input};
use Zend\Hydrator\ClassMethods;
class Login extends Form
{
    public function addElements()
    {
        $this->setHydrator(new ClassMethods());
        $this->setAttributes(['method' => 'post']);
        
        $email = new Element\Email('email');
        $email->setLabel('Email Address');        
        $email->setAttributes(['size' => 40]);
        $this->add($email);
        
        $password = new Element\Password('password');
        $password->setLabel('Password');        
        $password->setAttributes(['size' => 40]);
        $this->add($password);
        
        $submit = new Element\Submit('submit');
        $submit->setAttributes(['value' => 'Login',
                                'style' => 'color:white;background-color:green;']);
        $this->add($submit);
    }

    public function addInputFilter()
    {
        $inputFilter = new InputFilter();
        
        $email = new Input('email');
        $email->getValidatorChain()
              ->attach(new Validator\EmailAddress());
        $email->getFilterChain()
              ->attach(new Filter\StringTrim())
              ->attach(new Filter\StripTags());              
        $inputFilter->add($email);
        
        $password = new Input('password');
        $password->getValidatorChain()
              ->attach(new Validator\NotEmpty());
        $inputFilter->add($password);
        
        $this->setInputFilter($inputFilter);
        return $inputFilter;
    }
}
