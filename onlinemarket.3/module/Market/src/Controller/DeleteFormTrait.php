<?php
namespace Market\Controller;

use Market\Form\DeleteForm;

trait DeleteFormTrait
{
    protected $deleteForm;
    public function setDeleteForm(DeleteForm $form)
    {
        $this->deleteForm = $form;
        return $this;
    }

    public function getDeleteForm()
    {
        return $this->deleteForm;
    }

}
