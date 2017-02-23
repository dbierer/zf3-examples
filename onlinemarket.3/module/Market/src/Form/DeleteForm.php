<?php
namespace Market\Form;

use Zend\Form\Element;
use Zend\Form\Form;

class DeleteForm extends Form
{
    public function prepareElements()
	{

		$id = new Element\Hidden('itemId');
        $noBots = new Element\Hidden('noBots');

		$delCode = new Element\Text('deleteCode');
		$delCode->setLabel('Delete Code')
			 ->setAttribute('title', 'Enter code needed to delete this posting')
			 ->setAttribute('size', 40)
			 ->setAttribute('maxlength', 128);


		$submit = new Element\Submit('submit');
		$submit->setAttribute('value', 'Delete')
			   ->setAttribute('title', 'Click here to delete this item');

		$cancel = new Element\Submit('cancel');
		$cancel->setAttribute('value', 'Cancel')
			   ->setAttribute('title', 'Click here to cancel deletion');

		$this->add($id)
			 ->add($noBots)
			 ->add($delCode)
			 ->add($submit)
			 ->add($cancel);
	}
}
