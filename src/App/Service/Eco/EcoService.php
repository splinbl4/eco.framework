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

    public static function create(Eco $eco, ContainerInterface $container): Eco
    {
        $doctrine = $container->get('doctrine');

        $entityManager = $doctrine->getManager();
        $entityManager->persist($eco);
        $entityManager->flush();

        return $eco;
    }

    public function setCoordinates() :void
    {
        $this->eco->setCoordX($this->location->setCoordinate());
        $this->eco->setCoordY($this->location->setCoordinate());
    }

    public function getCoordinates() :array
    {
        return [
            'coordX' => $this->eco->getCoordX(),
            'coordY' => $this->eco->getCoordY(),
        ];
    }

    public function displacement() :void
    {
        $this->eco->setCoordX($this->location->displacement($this->eco->getCoordX()));
        $this->eco->setCoordY($this->location->displacement($this->eco->getCoordY()));
    }

    public function getType() :string
    {
        return get_class($this->eco);
    }
}