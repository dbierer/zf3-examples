<?php
namespace Events\Doctrine\Controller;

use Events\Doctrine\Repository\ {EventRepo, AttendeeRepo, RegistrationRepo};

interface RepoAwareInterface
{
    public function setEventRepo(EventRepo $repo);
    public function setAttendeeRepo(AttendeeRepo $repo);
    public function setRegistrationRepo(RegistrationRepo $repo);
}
