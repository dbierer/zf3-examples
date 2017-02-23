<?php
namespace Tutorial\Form\Factory;

use Zend\Form\Factory as ZFF;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class FormFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $form = (new ZFF())->createForm($container->get('tutorial-form-config'));
        $form->setInputFilter($container->get('tutorial-filter'));
        return $form;
    }
}
