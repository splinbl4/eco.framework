<?php

namespace App\UseCase\Collection;

use App\Entity\Animal\Herbivore;
use App\Entity\Animal\LargePredator;
use App\Entity\Animal\SimplePredator;
use App\Entity\Observer;
use App\Entity\Plants\Plant;
use App\Service\Animal\HerbivoreService;
use App\Service\Animal\PredatorService;
use App\UseCase\Location;

class EcoCollection extends Collection
{
    public static function createCollection(Location $location) :self
    {
        $ecoCollection = new self;

        $ecoCollection->add(new SimplePredator(new PredatorService(), $location, 'simplePredator1'));
        $ecoCollection->add(new SimplePredator(new PredatorService(), $location, 'simplePredator2'));
        $ecoCollection->add(new LargePredator(new PredatorService(), $location, 'largePredator'));
        $ecoCollection->add(new Herbivore(new HerbivoreService(), $location, 'herbivore1'));
        $ecoCollection->add(new Herbivore(new HerbivoreService(), $location, 'herbivore2'));
        $ecoCollection->add(new Plant($location, 'plants'));
        $ecoCollection->add(new Observer($location));
        $ecoCollection->add(new Observer($location));

        return $ecoCollection;
    }

    public function isOverlay(int $current, int $offset) :bool
    {
        if ($this->offsetGet($offset) && $this->offsetGet($current)) {
            if (
                $this->offsetGet($current)->getCoordX() === $this->offsetGet($offset)->getCoordX()
                && $this->offsetGet($current)->getCoordY() === $this->offsetGet($offset)->getCoordY()
            ) {

                return true;
            }
        }

        return false;
    }

    public function displacement() :void
    {
        foreach ($this->container as $item) {
            $item->setCoordX($item->location->displacement($item->getCoordX()));
            $item->setCoordY($item->location->displacement($item->getCoordY()));
        }
    }

    public function checkType($type) :bool
    {
        foreach ($this->container as $item) {
            if ($item instanceof $type) {
                return true;
            }
        }

        return false;
    }
}