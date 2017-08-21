<?php
namespace Events\Doctrine\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity("Events\Doctrine\Entity\Event")
 * @ORM\Table("doctrine_event")
 */
class Event
{
    /**
     * @ORM\Column(type="integer", length=11)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $name;
    
    /**
     * @ORM\Column(type="integer", length=4)
     */
    protected $max_attendees;
    
    /**
     * @ORM\Column(type="datetime")
     */
    protected $date;
    
    /**
     * @ORM\OneToMany(targetEntity="Events\Doctrine\Entity\Registration", mappedBy="eventLink")
     */
    protected $registrations = array();
    
    public function __construct()
    {
        $this->registrations = new ArrayCollection();
    }
    
    /**
	 * @return the $id
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @return the $name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @return the $max_attendees
	 */
	public function getMax_attendees() {
		return $this->max_attendees;
	}

	/**
	 * @return the $date
	 */
	public function getDate() {
		return $this->date;
	}

	/**
	 * @param field_type $id
	 */
	public function setId($id) {
		$this->id = $id;
	}

	/**
	 * @param field_type $name
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * @param field_type $max_attendees
	 */
	public function setMax_attendees($max_attendees) {
		$this->max_attendees = $max_attendees;
	}

	/**
	 * @param field_type $date
	 */
	public function setDate($date) {
		$this->date = $date;
	}

	/**
     * @return the $registrations
     */
    public function getRegistrations()
    {
        return $this->registrations;
    }

    /**
     * @param Application\Entity\Registration $registration
     */
    public function setRegistrations($registration)
    {
        $this->registrations[] = $registration;
    }


    
    
}
