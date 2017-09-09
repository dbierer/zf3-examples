<?php
namespace Login\Form;

use Zend\Filter;
use Zend\Validator;
use Zend\Form\ {Form, Element};
use Zend\InputFilter\ {InputFilter, Input};
use Zend\Hydrator\ClassMethods;
class Login extends Form
{
    protected $localeList;
    public function setLocaleList($list)
    {
        $this->localeList = $list;
    }
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
        
        $locale = new Element\Select('locale');
        $locale->setLabel('Preferred Language');        
        $locale->setValueOptions($this->localeList);
        $this->add($locale);
        
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
        
        $locale = new Input('locale');
        $locale->getValidatorChain()
              ->attach(new Validator\InArray(['haystack' => array_keys($this->localeList)]));
        $locale->getFilterChain()
              ->attach(new Filter\StringTrim())
              ->attach(new Filter\StripTags());              
        $inputFilter->add($locale);
        
        $password = new Input('password');
        $password->setRequired(FALSE);
        $password->getFilterChain()
              ->attach(new Filter\StringTrim());                      
        $inputFilter->add($password);
        
        $this->setInputFilter($inputFilter);
        return $inputFilter;
    }
}
