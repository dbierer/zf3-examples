<?php
namespace Login\Form;

use Zend\Form\ {Fieldset, Element};
use Zend\InputFilter\ {InputFilter, FileInput};
use Zend\Hydrator\ClassMethods;
class Register extends Fieldset
{
    public function addElements()
    {
        $question = new Element\Text('security_question');
        $question->setLabel('Security Question');
        $this->add($question);
        $answer = new Element\Text('security_answer');
        $answer->setLabel('Security Question');
        $this->add($answer);
    }
    public function addInputFilter()
    {
        parent::addInputFilter();
        $email = new Input('email');
        $email->getValidatorChain()
              ->attach(new Validator\EmailAddress());
        $email->getFilterChain()
              ->attach(new StringTrim())
              ->attach(new StripTags());              
        $inputFilter->add($email);
        $this->setInputFilter($inputFilter);
    }
}
