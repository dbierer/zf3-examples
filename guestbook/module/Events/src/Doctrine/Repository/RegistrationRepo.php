<?php
namespace Application\Repository;

use Doctrine\ORM\EntityRepository;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;
use Application\Entity\Registration;
use Application\Entity\Event;

class RegistrationRepo extends EntityRepository implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;
    
    /**
     * @param Application\Entity\Event $eventEntity
     * @param array $regData
     * @return Application\Entity\Registration $registration
     */
    public function persist(Event $eventEntity, $regData)
    {
        $registration = new Registration();
        $registration->setFirstName($regData['firstName']);
        $registration->setLastName($regData['lastName']);
        $registration->setEventLink($eventEntity);
        $registration->setRegistrationTime(new \DateTime('now'));
        // NOTE: the $event property is actually not needed, but retained for backwards compatibility
        $registration->setEvent($eventEntity->getId());
        return $this->update($registration);
    }
    public function update($registration)
    {
        $em = $this->getEntityManager();
        $em->persist($registration);
        $em->flush();
        return $registration;
    }
} 
