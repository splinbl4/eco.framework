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
    /**
     * Создание коллекции сущностей игры
     *
     * @param Location $location
     * @return EcoCollection
     */
    public static function createCollection(Location $location) :self
    {
        $ecoCollection = new self;

        $ecoCollection->add(new SimplePredator($location, 'simplePredator1'));
        $ecoCollection->add(new SimplePredator($location, 'simplePredator2'));
        $ecoCollection->add(new LargePredator($location, 'largePredator'));
        $ecoCollection->add(new Herbivore($location, 'herbivore1'));
        $ecoCollection->add(new Herbivore($location, 'herbivore2'));
        $ecoCollection->add(new Plant($location, 'plants'));
        $ecoCollection->add(new Observer($location));
        $ecoCollection->add(new Observer($location));

        return $ecoCollection;
    }

    /**
     * Проверка на совпадение координат сущностей игры
     *
     * @param int $current
     * @param int $offset
     * @return bool
     */
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

    /**
     * Перемещение сущности игры
     */
    public function displacement() :void
    {
        foreach ($this->container as $item) {
            $item->setCoordX($item->location->displacement($item->getCoordX()));
            $item->setCoordY($item->location->displacement($item->getCoordY()));
        }
    }

    /**
     * Проверка существования типа сущности игры в коллекции
     *
     * @param $type
     * @return bool
     */
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