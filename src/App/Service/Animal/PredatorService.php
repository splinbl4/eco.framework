<?php

namespace App\Service\Animal;

use App\Entity\GameResult;
use App\UseCase\Collection\EcoCollection;
use Psr\Log\LoggerInterface;

class PredatorService implements AnimalService
{
    /**
     * Взаимодействие хищника с другими сущностями игры, а также запись в логи и базу этого взаимодействия
     *
     * @param int $current
     * @param int $offset
     * @param EcoCollection $collection
     * @param LoggerInterface $log
     * @param GameResult $gameResult
     * @throws \Exception
     */
    public function eat(int $current, int $offset, EcoCollection $collection, LoggerInterface $log, GameResult $gameResult): void
    {
        if (!$collection->offsetExists($offset)) {
            throw new \Exception('Invalid offset');
        }

        $collection->offsetGet($offset)->setIsEaten(true);

        $log->info(
            $collection->offsetGet($current)->getName() . ' eat ' . $collection->offsetGet($offset)->getName(),
            $collection->offsetGet($offset)->getFields()
        );

        $gameResult->setFields(
            $collection->offsetGet($current)->getName() . ' eat ' . $collection->offsetGet($offset)->getName(),
            $collection->offsetGet($offset)->getFields()
        );

        $collection->remove($offset);
    }
}