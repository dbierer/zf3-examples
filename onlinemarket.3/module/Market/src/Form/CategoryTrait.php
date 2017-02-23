<?php
namespace Market\Form;

trait CategoryTrait
{
	protected $categories;
	/**
	 * @return the $categories
	 */
	public function getCategories() {
		return $this->categories;
	}

	/**
	 * @param field_type $categories
	 */
	public function setCategories($categories) {
		$this->categories = $categories;
	}

}
