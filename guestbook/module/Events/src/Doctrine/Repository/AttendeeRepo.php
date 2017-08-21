<?php
namespace Application\Repository;

use Doctrine\ORM\EntityRepository;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;
use Application\Entity\Attendee;

class AttendeeRepo extends EntityRepository 
                   implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    /**
     * @param Application\Entity\Registration $regEntity
     * @param string $nameOnTicket
     * @return Application\Entity\Attendee
     */
    public function persist($regEntity, $nameOnTicket)
    {
        $attendee = new Attendee();
        $attendee->setRegistration($regEntity);
        $attendee->setName($nameOnTicket);
        $em = $this->getEntityManager();
        $em->persist($attendee);
        $em->flush();
        return $attendee;
    }
} 
