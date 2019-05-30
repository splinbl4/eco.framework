<?php

namespace App\Service\Observers;

use App\Entity\GameResult;
use App\UseCase\Collection\EcoCollection;
use Psr\Log\LoggerInterface;

class ObserverService
{
    /**
     * Взаимодействие наблюдателя с растением, а также запись в логи и базу этого взаимодействия
     *
     * @param int $current
     * @param int $offset
     * @param EcoCollection $collection
     * @param LoggerInterface $log
     * @param GameResult $gameResult
     * @throws \Exception
     */
    public function take(int $current, int $offset, EcoCollection $collection, LoggerInterface $log, GameResult $gameResult): void
    {
        if (!$collection->offsetExists($offset)) {
            throw new \Exception('Invalid offset');
        }

        $log->info(
            'Observer № ' . $collection->offsetGet($current)->getId() . ' take ' . $collection->offsetGet($offset)->getName(),
            $collection->offsetGet($offset)->getFields()
        );

        $gameResult->setFields(
            'Observer № ' . $collection->offsetGet($current)->getId() . ' take ' . $collection->offsetGet($offset)->getName(),
            $collection->offsetGet($offset)->getFields()
        );

        $collection->remove($offset);
    }
}