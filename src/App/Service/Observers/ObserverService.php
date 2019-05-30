<?php

namespace App\Service\Observers;

use App\Entity\GameResult;
use App\UseCase\Collection\EcoCollection;
use Psr\Log\LoggerInterface;

class ObserverService
{
    public function take(int $current, int $offset, EcoCollection $collection, LoggerInterface $log, GameResult $response): void
    {
        if (!$collection->offsetExists($offset)) {
            throw new \Exception('Invalid offset');
        }

        $log->info(
            'Observer № ' . $collection->offsetGet($current)->getId() . ' take ' . $collection->offsetGet($offset)->getName(),
            $collection->offsetGet($offset)->getFields()
        );

        $response->setFields(
            'Observer № ' . $collection->offsetGet($current)->getId() . ' take ' . $collection->offsetGet($offset)->getName(),
            $collection->offsetGet($offset)->getFields()
        );

        $collection->remove($offset);
    }
}