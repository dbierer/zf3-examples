<?php
namespace Events\TableModule\Controller;

use Events\TableModule\Model\ {EventTable, RegistrationTable, AttendeeTable};

trait TableTrait
{
    protected $eventTable;
    protected $registrationTable;
    protected $attendeeTable;
    public function setEventTable($table)
    {
        $this->eventTable = $table;
    }
    public function setRegistrationTable($table)
    {
        $this->registrationTable = $table;
    }
    public function setAttendeeTable($table)
    {
        $this->attendeeTable = $table;
    }
}
