<?php
namespace Market\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Zend\Captcha\Image as ImageCaptcha;

class PostForm extends Form
{

    use CaptchaTrait;
	use CategoryTrait;
	use ExpireDaysTrait;

    protected $captchaOptions;

    public function buildForm()
    {

        $this->setAttribute('method', 'post');

        $category = new Element\Select('category');
        $category->setLabel('Category')
                 ->setAttribute('title', 'Please select one of these categories')
                 ->setValueOptions(array_combine($this->getCategories(),$this->getCategories()));

        $title = new Element\Text('title');
        $title->setLabel('Title')
              ->setAttribute('placeholder', 'Enter a Title for this Posting');

        $photo = new Element\Text('photo_filename');
		$photo->setLabel('Photo')
			  ->setAttribute('maxlength', 1024)
		      ->setAttribute('placeholder', 'Enter URL of a JPG');

		$price = new Element\Text('price');
		$price->setLabel('Price')
			  	 ->setAttribute('title', 'Enter price as nnn.nn')
	 		  	 ->setAttribute('size', 16)
			  	 ->setAttribute('maxlength', 16)
		         ->setAttribute('placeholder', 'Enter some value');

		$expires = new Element\Radio('expires');
		$expires->setLabel('Expires')
			    ->setAttribute('title', 'The expiration date will be calculated from today')
			    ->setAttribute('class', 'expiresButton')
			    ->setValueOptions($this->getExpireDays());

		$city = new Element\Text('cityCode');
		$city->setLabel('Nearest City')
			  ->setAttribute('title', 'Select the city of the item')
			  ->setAttribute('id', 'cityCode')
		      ->setAttribute('placeholder', 'Start typing and choose the city');

		$name = new Element\Text('contact_name');
		$name->setLabel('Contact Name')
			 ->setAttribute('title', 'Enter the name of the person to contact for this item')
			 ->setAttribute('size', 40)
			 ->setAttribute('maxlength', 255);

		$phone = new Element\Text('contact_phone');
		$phone->setLabel('Contact Phone Number')
			  ->setAttribute('title', 'Enter the phone number of the person to contact for this item')
			  ->setAttribute('size', 20)
			  ->setAttribute('maxlength', 32);

		$email = new Element\Email('contact_email');
		$email->setLabel('Contact Email')
			  ->setAttribute('title', 'Enter the email address of the person to contact for this item')
			  ->setAttribute('size', 40)
			  ->setAttribute('maxlength', 255);

		$description = new Element\Textarea('description');
		$description->setLabel('Description')
					->setAttribute('title', 'Enter a suitable description for this posting')
					->setAttribute('rows', 4)
					->setAttribute('cols', 80);

		$delCode = new Element\Text('delete_code');
		$delCode->setLabel('Delete Code')
			 ->setAttribute('title', 'Enter the delete code for this item')
			 ->setAttribute('size', 16)
			 ->setAttribute('maxlength', 16);

		$captcha = new Element\Captcha('captcha');
		$captchaAdapter = new ImageCaptcha();
		$captchaAdapter->setWordlen(4)
			  		   ->setOptions($this->getCaptchaOptions());
		$captcha->setCaptcha($captchaAdapter)
				->setLabel('Help us to prevent SPAM!')
				->setAttribute('class', 'captchaStyle')
				->setAttribute('title', 'Help to prevent SPAM');

		$submit = new Element\Submit('submit');
		$submit->setAttribute('value', 'Post');

		$this->add($category)
			 ->add($title)
			 ->add($photo)
			 ->add($price)
			 ->add($expires)
			 ->add($city)
			 ->add($name)
			 ->add($phone)
			 ->add($email)
			 ->add($description)
			 ->add($delCode)
			 ->add($captcha)
			 ->add($submit);
    }

}
