<?php
namespace Market\Form;

use Zend\InputFilter\ {InputFilter,Input};
use Zend\Filter\ {Digits, StripTags, StringTrim, StringToLower, StringToUpper, Callback};
use Zend\Validator\ {InArray, StringLength, Regex};
use Zend\I18n\Validator\ {Alnum, ToFloat};

class PostFilter extends InputFilter
{

	use CategoryTrait;
	use ExpireDaysTrait;

    public function buildFilter()
    {

		// filter & validate by fields
		$category = new Input('category');
		$category->getFilterChain()
				 ->attachByName('StringToLower');
		$category->getValidatorChain()
				 ->attachByName('InArray', ['haystack' => $this->getCategories()]);

		$title = new Input('title');
		$titleRegex = new Regex(['pattern' => '/^[a-zA-Z0-9 ]*$/']);
		$titleRegex->setMessage('Title should only contain numbers, letters or spaces!');
		$title->getValidatorChain()
			  ->attach($titleRegex)
			  ->attachByName('StringLength', ['min' => 1, 'max' => 128]);

		$photo = new Input('photo_filename');
		$photo->getValidatorChain()
			  ->attachByName('Regex', ['pattern' => '!^(http(s)?://)?[a-z0-9./_-]+(jp(e)?g|png)$!i']);
		$photo->setErrorMessage('Photo must be a URL or a valid filename ending with jpg or png');

        $float = new Callback(function ($val) { return (float) $val; });
		$price = new Input('price');
		$price->setAllowEmpty(TRUE);
		$price->getValidatorChain()
			  ->attachByName('GreaterThan', ['min' => 0.00, 'inclusive' => true]);
		$price->getFilterChain()
			  ->attach($float);

		$expires = new Input('expires');
		$expires->setAllowEmpty(TRUE);
		$expires->getValidatorChain()
				->attachByName('InArray', ['haystack' => array_keys($this->getExpireDays())]);
		$expires->getFilterChain()
                ->attach(new Digits());

		$city = new Input('city');
		$city->getValidatorChain()
             ->attach(new Regex(['pattern' => '/[A-Z 0-9,-]+/i']));

		$country = new Input('country');
		$country->getValidatorChain()
                ->attach(new StringLength(['min' => 2, 'max' => 2]));
        $country->getFilterChain()
                ->attach(new StringToUpper());

		$name = new Input('contact_name');
		$name->setAllowEmpty(TRUE);
		$name->getValidatorChain()
			  ->attachByName('Regex', ['pattern' => '/^[a-z0-9., -]{1,255}$/i']);
		$name->setErrorMessage('Name should only contain letters, numbers, and some punctuation.');

		$phone = new Input('contact_phone');
		$phone->setAllowEmpty(TRUE);
		$phone->getValidatorChain()
			  ->attachByName('Regex', ['pattern' => '/^\+?\d{1,4}(-\d{3,4})+$/']);
		$phone->setErrorMessage('Phone number must be in this format: +nnnn-nnn-nnn-nnnn');

		$email = new Input('contact_email');
		$email->setAllowEmpty(TRUE);
		$email->getValidatorChain()
			  ->attachByName('EmailAddress');

		$description = new Input('description');
		$description->setAllowEmpty(TRUE);
		$description->getValidatorChain()
					->attachByName('StringLength', ['min' => 1, 'max' => 4096]);

		$delCode = new Input('delete_code');
		$delCode->setRequired(TRUE);
		$delCode->getValidatorChain()
			    ->addByName('Digits');

		$this->add($category)
			 ->add($title)
			 ->add($photo)
			 ->add($price)
			 ->add($expires)
			 ->add($city)
			 ->add($country)
			 ->add($name)
			 ->add($phone)
			 ->add($email)
			 ->add($description)
		     ->add($delCode);

        // add StripTags + StringTrim to all
        $stripTags = new StripTags();
        $stringTrim = new StringTrim();
        foreach ($this->getInputs() as $input) {
            $input->getFilterChain()
                  ->attach($stripTags)
                  ->attach($stringTrim);
        }
    }

}
