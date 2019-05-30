<?php

namespace App\UseCase;

use App\Entity\GameResult;
use App\UseCase\Collection\EcoCollection;
use Monolog\Logger;

class Eat
{
    public function toEat(int $offset, EcoCollection $collection, Logger $log, GameResult $response) :void
    {
        if (!$collection->offsetExists($offset)) {
            throw new \Exception('Invalid offset');
        }

        $collection->offsetGet($offset)->setIsEaten(true);

        $log->info(
            $this->getName() . ' eat ' . $collection->offsetGet($offset)->getName(),
            $collection->offsetGet($offset)->getFields()
        );

        $response->setFields(
            $this->getName() . ' eat ' . $collection->offsetGet($offset)->getName(),
            $collection->offsetGet($offset)->getFields()
        );

        $collection->remove($offset);
    }
}