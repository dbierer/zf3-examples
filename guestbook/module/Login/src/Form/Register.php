<?php
namespace Login\Form;

use Zend\Filter;
use Zend\Validator;
use Zend\I18n\Validator\Alnum;
use Zend\Form\ {Form, Element};
use Zend\InputFilter\ {InputFilter, Input};
use Zend\Hydrator\ClassMethods;

class Register extends Login
{
    public function addElements()
    {
        parent::addElements();
        
        $name = new Element\Text('username');
        $name->setLabel('User Name');
        $name->setAttributes(['size' => 40]);
        $this->add($name);
        
        $question = new Element\Text('securityQuestion');
        $question->setLabel('Security Question');
        $question->setAttributes(['size' => 40]);
        $this->add($question);
        
        $answer = new Element\Text('securityAnswer');
        $answer->setLabel('Security Answer');
        $answer->setAttributes(['size' => 40]);
        $this->add($answer);
        
        $submit = $this->get('submit');
        $submit->setAttributes(['value' => 'Register',
                                'style' => 'color:white;background-color:green;']);
    }
    
    public function addInputFilter()
    {
        $inputFilter = parent::addInputFilter();
        
        $username = new Input('username');
        $username->getValidatorChain()
              ->attach(new Validator\NotEmpty())
              ->attach(new Alnum());
        $username->getFilterChain()
              ->attach(new Filter\StringTrim())
              ->attach(new Filter\StripTags());              
        $inputFilter->add($username);
        
        $question = new Input('securityQuestion');
        $question->getValidatorChain()
              ->attach(new Validator\NotEmpty());
        $question->getFilterChain()
              ->attach(new Filter\StringTrim())
              ->attach(new Filter\StripTags());              
        $inputFilter->add($question);
        
        $answer = new Input('securityAnswer');
        $answer->getValidatorChain()
              ->attach(new Validator\NotEmpty());
        $answer->getFilterChain()
              ->attach(new Filter\StringTrim())
              ->attach(new Filter\StripTags());              
        $inputFilter->add($answer);
        
        $this->setInputFilter($inputFilter);
        return $inputFilter;
    }
}
