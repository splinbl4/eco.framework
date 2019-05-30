<?php

namespace App\Service\Animal;

use App\Entity\GameResult;
use App\UseCase\Collection\EcoCollection;
use Psr\Log\LoggerInterface;

class PredatorService implements AnimalService
{
    public function eat(int $current, int $offset, EcoCollection $collection, LoggerInterface $log, GameResult $response): void
    {
        if (!$collection->offsetExists($offset)) {
            throw new \Exception('Invalid offset');
        }

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
}