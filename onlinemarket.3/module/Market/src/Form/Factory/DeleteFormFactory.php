<?php
namespace Market\Form\Factory;

use Market\Form\DeleteForm;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class DeleteFormFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $form = new DeleteForm();
        $form->prepareElements();
        $form->setInputFilter($container->get('Market\Form\DeleteFormFilter'));
        return $form;
    }
}
