<?php

namespace App\Service\Animal;

use App\Entity\GameResult;
use App\Entity\Plants\Plant;
use App\UseCase\Collection\EcoCollection;
use Psr\Log\LoggerInterface;

class HerbivoreService implements AnimalService
{
    public function eat(int $current, int $offset, EcoCollection $collection, LoggerInterface $log, GameResult $response): void
    {
        if ($collection->offsetExists($offset)) {
            if ($collection->offsetGet($offset) instanceof Plant) {
                $collection->offsetGet($offset)->setIsEaten(true);

                $log->info(
                    $collection->offsetGet($current)->getName() . ' eat ' . $collection->offsetGet($offset)->getName(),
                    $collection->offsetGet($offset)->getFields()
                );

                $response->setFields(
                    $collection->offsetGet($current)->getName() . ' eat ' . $collection->offsetGet($offset)->getName(),
                    $collection->offsetGet($offset)->getFields()
                );

                $collection->remove($offset);
            }
        } else {
            throw new \Exception('Invalid offset');
        }
    }
}