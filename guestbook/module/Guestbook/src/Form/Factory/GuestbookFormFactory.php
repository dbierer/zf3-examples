<?php
namespace Guestbook\Form\Factory;

use Guestbook\Form\GuestbookAvatar;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

use Guestbook\Form\Guestbook as GuestbookForm;

class GuestbookFormFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        $form = new GuestbookForm();
        return $form;
    }
}
