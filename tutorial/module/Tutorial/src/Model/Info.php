<?php
namespace Tutorial\Model;

class Info
{
    protected $website;
    protected $owner;
    protected $notes;
    public function __construct($website, $owner, $notes = NULL)
    {
        $this->setWebsite($website);
        $this->setOwner($owner);
        $this->setNotes($notes);
    }
    /**
     * @return the $website
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * @return the $owner
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @return the $notes
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * @param field_type $website
     */
    public function setWebsite($website)
    {
        $this->website = $website;
    }

    /**
     * @param field_type $owner
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
    }

    /**
     * @param field_type $notes
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;
    }

    
}