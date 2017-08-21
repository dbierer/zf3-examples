<?php
namespace Application\Repository;

use Doctrine\ORM\EntityRepository;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

class EventRepo extends EntityRepository implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;
    public function findById($eventId)
    {
        return $this->findOneBy(array('id' => $eventId));
    }
    public function save($event)
    {
        $this->getEntityManager()->persist($event);
        $this->getEntityManager()->flush();
    }
} 