<?php
namespace Market\Controller;

use Market\Form\PostFilter;

trait PostFilterTrait
{
    protected $postFilter;
    public function setPostFilter(PostFilter $filter)
    {
        $this->postFilter = $filter;
        return $this;
    }

    public function getPostFilter()
    {
        return $this->postFilter;
    }

}
