<?php
namespace Market\Form\Factory;

use Market\Form\PostForm;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class PostFormFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $form = new PostForm();
        $form->setExpireDays($container->get('market-expire-days'));
        $form->setCategories($container->get('market-categories'));
        $form->setCaptchaOptions($container->get('market-captcha-options'));
        $form->buildForm();
        $form->setInputFilter($container->get(\Market\Form\PostFilter::class));
        return $form;
    }
}
