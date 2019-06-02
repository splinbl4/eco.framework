<?php

namespace App\Entity\Animal;

use App\Entity\Eco;
use App\Service\Animal\AnimalService;
use App\UseCase\Location;

abstract class Animal extends Eco
{
    protected $name;
    protected $power;
    protected $minPower;
    protected $maxPower;

    public function __construct(Location $location, string $name, int $power = null)
    {
        parent::__construct($location);

        $this->setName($name);
        $this->setPower($power);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPower(): int
    {
        return $this->power;
    }

    public function setPower(int $power = null): self
    {
        $this->power = $power ?? rand($this->getMinPower(), $this->getMaxPower());

        return $this;
    }

    public function getMinPower(): int
    {
        return $this->minPower;
    }

    public function setMinPower(int $minPower): self
    {
        $this->minPower = $minPower;

        return $this;
    }

    public function getMaxPower(): int
    {
        return $this->maxPower;
    }

    public function setMaxPower(int $maxPower): self
    {
        $this->maxPower = $maxPower;

        return $this;
    }

    public function isStronger(Animal $animal) :bool
    {
        return $this->power > $animal->power;
    }

    public function isEqual(Animal $animal) :bool
    {
        return $this->power === $animal->power;
    }

    public function getFields(): array
    {
        return array_merge(
            [
                'name' => $this->name,
                'power' => $this->power
            ],
            parent::getFields()
        );
    }

    /**
     * Съедение сущности игры
     *
     * @param Eco $entity
     */
    public function eat(Eco $entity): void
    {
        $entity->setIsEaten(true);
    }
}