<?php

namespace App\Service\Animal;

use App\Entity\GameResult;
use App\Entity\Plants\Plant;
use App\UseCase\Collection\EcoCollection;
use Psr\Log\LoggerInterface;

class HerbivoreService implements AnimalService
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
        if ($collection->offsetExists($offset)) {
            if ($collection->offsetGet($offset) instanceof Plant) {
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
        } else {
            throw new \Exception('Invalid offset');
        }
    }
}