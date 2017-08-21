<?php
namespace Events;
use Events\Doctrine\Repository\ {AttendeeRepo, EventRepo, RegistrationRepo};
use Events\Doctrine\Controller\RepoAwareInterface;
use Events\TableModule\Controller\ServiceLocatorAwareInterface;
use Zend\Db\Adapter\Adapter;
use Zend\Filter;
class Module
{
    const VERSION = '3.0.3-dev';

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
    public function getControllerConfig()
    {
        return [
            'initializers' => [
                'events-init-service-locator' => function ($container, $instance) {
                    if ($instance instanceof ServiceLocatorAwareInterface) {
                        $instance->setServiceLocator($container);
                    }
                },
              'events-doctrine-inject-repos' => function ($container, $instance) {
                  if ($instance instanceof RepoAwareInterface) {
                      $instance->setEventRepo(
                        $container->get('events-doctrine-repo-event'));
                      $instance->setAttendeeRepo(
                        $container->get('events-doctrine-repo-attendee'));
                      $instance->setRegistrationRepo(
                        $container->get('events-doctrine-repo-registration'));
                  }
              }
            ],
        ];
    }
    public function getServiceConfig()
    {
        return [
            'factories' => [
                'events-db-adapter' => function ($container) {
                    return new Adapter($container->get('local-db-config'));
                },
                'events-reg-data-filter' => function ($sm) {
                    $filter = new Filter\FilterChain();
                    $filter->attach(new Filter\StringTrim())
                           ->attach(new Filter\StripTags());
                    return $filter;
                },
                'events-doctrine-repo-event'       => function ($sm) {
                    $em = $sm->get('doctrine.entitymanager.orm_default');
                    return new EventRepo($em, $em->getClassMetadata('Events\Doctrine\Entity\Event'));
                },
                'events-doctrine-repo-registration'=> function ($sm) {
                    $em = $sm->get('doctrine.entitymanager.orm_default');
                    return new RegistrationRepo($em, $em->getClassMetadata('Events\Doctrine\Entity\Registration'));
                },
                'events-doctrine-repo-attendee'    => function ($sm) {
                    $em = $sm->get('doctrine.entitymanager.orm_default');
                    return new AttendeeRepo($em, $em->getClassMetadata('Events\Doctrine\Entity\Attendee'));
                },
                'events-doctrine-data-filter'   => function ($sm) {
                    $filter = new Filter\FilterChain();
                    $filter->attach(new Filter\StringTrim())
                          ->attach(new Filter\StripTags());
                    return $filter;
                },
            ],
            'initializers' => [
                'events-init-table-modules' => function ($container, $instance) {
                    if ($instance instanceof TableModule\Model\Base) {
                        $instance->setTableGateway($container->get('events-db-adapter'));
                    }
                },
            ],
        ];                    
    }
}
