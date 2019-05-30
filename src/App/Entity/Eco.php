<?php

namespace App\Entity;

use App\UseCase\Location;
use App\Service\Eco\EcoService;

abstract class Eco
{
    protected $id;
    protected $coordX;
    protected $coordY;
    protected $isEaten = false;
    public $location;
    protected $step = 1;
    public $ecoService;

    public function __construct(Location $location)
    {
        $this->location = $location;
        $this->ecoService = new EcoService($this, $location);
        $this->ecoService->setCoordinates();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCoordX(): int
    {
        return $this->coordX;
    }

    public function setCoordX(int $coordX): self
    {
        $this->coordX = $coordX;

        return $this;
    }

    public function getCoordY(): int
    {
        return $this->coordY;
    }

    public function setCoordY(int $coordY): self
    {
        $this->coordY = $coordY;

        return $this;
    }

    public function getIsEaten(): bool
    {
        return $this->isEaten;
    }

    public function setIsEaten(bool $isEaten): self
    {
        $this->isEaten = $isEaten;

        return $this;
    }

    public function getStep(): int
    {
        return $this->step;
    }

    public function setStep(int $step): self
    {
        $this->step = $step;

        return $this;
    }

    public function getFields() :array
    {
        return [
            'type' => $this->ecoService->getType(),
            'coordX' => $this->getCoordX(),
            'coordY' => $this->getCoordY(),
        ];
    }
}
