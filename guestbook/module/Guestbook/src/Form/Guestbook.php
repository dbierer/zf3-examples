<?php
namespace Guestbook\Form;

use Zend\Form\ {Form, Element};
use Zend\InputFilter\ {InputFilter, FileInput};
use Zend\Hydrator\ClassMethods;
class Guestbook extends Form
{
    public function __construct($name = __CLASS__, $options = [])
    {
        parent::__construct($name, $options);
        $this->addElements();
        $this->addInputFilter();
        $this->setHydrator(new ClassMethods());
    }
    public function addElements()
    {
        $this->setAttributes(['method' => 'post']);
        $name = new Element\Text('name');
        $name->setLabel('Name');
        $this->add($name);
        $email = new Element\Email('email');
        $email->setLabel('Email Address');
        $this->add($email);
        $website = new Element\Url('website');
        $website->setLabel('Website');
        $this->add($website);
        $message = new Element\Textarea('message');
        $message->setLabel('Comments');
        $message->setAttributes(['rows' => 4, 'cols' => 80]);
        $this->add($message);
        $file = new Element\File('avatar');
        $file->setLabel('Avatar Image Upload');
        $this->add($file);
        $submit = new Element\Submit('submit');
        $submit->setAttributes(['value' => 'Sign Guestbook',
                                'style' => 'color:white;background-color:green;']);
        $this->add($submit);
    }
    public function addInputFilter()
    {
        $fileInput = new FileInput('avatar');
        $inputFilter = new InputFilter();
        
        // Define validators and filters as if only one file was being uploaded.
        $fileInput->getValidatorChain()
            ->attachByName('filesize',      ['max' => 204800])
            ->attachByName('filemimetype',  ['mimeType' => 'image/png,image/x-png,image/jpeg'])
            ->attachByName('fileimagesize', ['maxWidth' => 100, 'maxHeight' => 100]);

        // All files will be renamed, e.g.: /../../../../data/uploads/avatar_4b3403665fea6.png,
        $fileInput->getFilterChain()->attachByName(
            'filerenameupload',
            [
                'target'    => __DIR__ . '/../../../../data/uploads/avatar.png',
                'randomize' => true,
            ]
        );
        $inputFilter->add($fileInput);
        $this->setInputFilter($inputFilter);
    }
}
