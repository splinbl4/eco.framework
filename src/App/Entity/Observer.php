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

    private function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function getFields() :array
    {
        return array_merge(
            [
                'id' => $this->setId(random_int(1, 10))
            ],
            parent::getFields()
        );
    }
}