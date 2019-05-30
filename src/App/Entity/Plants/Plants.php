<?php

namespace App\Entity\Plants;

use App\Entity\Eco;
use App\UseCase\Location;

abstract class Plants extends Eco
{
    private $name;

    public function __construct(Location $location, string $name)
    {
        parent::__construct($location);

        $this->setName($name);
    }

    public function getName() :string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getFields(): array
    {
        return array_merge(
            [
                'name' => $this->name,
            ],
            parent::getFields()
        );
    }
}