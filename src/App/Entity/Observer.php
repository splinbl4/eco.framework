<?php

namespace App\Entity;

use App\Entity\Plants\Plants;
use App\UseCase\Location;

class Observer extends Eco
{
    public function __construct(Location $location)
    {
        parent::__construct($location);
        $this->setId(random_int(1, 10));
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
                'id' => $this->getId()
            ],
            parent::getFields()
        );
    }

    public function take(Plants $entity): void
    {
        $entity->setIsEaten(true);
    }
}