<?php

namespace App\Entity;

use App\Service\Observers\ObserverService;
use App\UseCase\Location;

class Observer extends Eco
{
    public $observerService;

    public function __construct(Location $location)
    {
        parent::__construct($location);
        $this->observerService = new ObserverService();
    }

    public function getFields() :array
    {
        return array_merge(
            [
                'id' => 1
            ],
            parent::getFields()
        );
    }
}