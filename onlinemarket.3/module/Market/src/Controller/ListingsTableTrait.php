<?php
namespace Market\Controller;

use Model\Table\Listings;

trait ListingsTableTrait
{
    protected $listingsTable;
    public function setListingsTable(Listings $table)
    {
        $this->listingsTable = $table;
    }
}
