<?php
namespace Application\Session;

use Zend\Session\SessionManager;

class CustomManager extends SessionManager
{    
    /**
     * Overrides parent writeClose()
     * 
     * The only reason I had to do this was to avoid this warning:
     * Warning: Erroneous data format for unserializing 'Zend\Stdlib\ArrayObject' in /home/fred/Desktop/Repos/ZF2Fundamentals-II/Course_Applications/guestbook/vendor/zendframework/zend-session/src/SessionManager.php on line 131
     * Warning: session_start(): Failed to decode session object. Session has been destroyed in /home/fred/Desktop/Repos/ZF2Fundamentals-II/Course_Applications/guestbook/vendor/zendframework/zend-session/src/SessionManager.php on line 131
     */
    public function writeClose()
    {
        // do nothing
    }
}
