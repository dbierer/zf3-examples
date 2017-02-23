<?php
namespace Market\Form;

use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;
use Zend\Filter\ {StringTrim, StripTags, Digits, PregReplace};

class DeleteFormFilter extends InputFilter
{
	public function prepareFilters()
	{
        $alnum = new PregReplace(['pattern' => '/[^0-9A-Z]/i', 'replacement' => '']);

		$id = new Input('itemId');
		$id->getFilterChain()
		   ->attach(new Digits());

		$delCode = new Input('deleteCode');
        $delCode->getFilterChain()
                ->attach($alnum);

        $noBots = new Input('noBots');
        $noBots->getFilterChain()
                ->attach($alnum);

		$this->add($id)
			 ->add($delCode)
             ->add($noBots);
	}
}
