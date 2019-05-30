<?php

namespace App\Service\Eco;

use App\Entity\Eco;
use App\UseCase\Location;
use Psr\Container\ContainerInterface;

class EcoService
{
    private $eco;
    private $location;

    public function __construct(Eco $eco, Location $location)
    {
        $this->eco = $eco;
        $this->location = $location;
    }

    /**
     * Установка координат для сущности игры
     */
    public function setCoordinates() :void
    {
        $this->eco->setCoordX($this->location->setCoordinate());
        $this->eco->setCoordY($this->location->setCoordinate());
    }

    /**
     *  Изменение координат сущности игры
     */
    public function displacement() :void
    {
        $this->eco->setCoordX($this->location->displacement($this->eco->getCoordX()));
        $this->eco->setCoordY($this->location->displacement($this->eco->getCoordY()));
    }

    /**
     * Получить тип сущности игры
     *
     * @return string
     */
    public function getType() :string
    {
        return get_class($this->eco);
    }
}