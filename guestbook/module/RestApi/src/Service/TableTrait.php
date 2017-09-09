<?php
namespace RestApi\Service;

use Events\TableModule\Model\ {EventTable, RegistrationTable, AttendeeTable};

trait TableTrait
{
    protected $eventTable;
    protected $regTable;
    protected $attendeeTable;

    public function setEventTable(EventTable $table)
    {
        $this->eventTable = $table;
        return $this;
    }
    public function getEventTable()
    {
        return $this->eventTable;
    }
    public function setRegistrationTable(RegistrationTable $table)
    {
        $this->registrationTable = $table;
        return $this;
    }
    public function getRegistrationTable()
    {
        return $this->registrationTable;
    }
    public function setAttendeeTable(AttendeeTable $table)
    {
        $this->attendeeTable = $table;
        return $this;
    }
    public function getAttendeeTable()
    {
        return $this->attendeeTable;
    }
}
