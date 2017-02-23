<?php
namespace Market\Controller;

use Market\Form\PostForm;

trait PostFormTrait
{
    protected $postForm;
    public function setPostForm(PostForm $form)
    {
        $this->postForm = $form;
        return $this;
    }

    public function getPostForm()
    {
        return $this->postForm;
    }

}
