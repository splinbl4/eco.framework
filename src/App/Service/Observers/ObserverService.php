<?php

namespace App\Service\Observers;

use App\Entity\Eco;
use App\Entity\GameResult;
use App\UseCase\Collection\EcoCollection;
use Psr\Log\LoggerInterface;

class ObserverService
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Взаимодействие наблюдателя с растением, а также запись в логи и базу этого взаимодействия
     * @param Eco $currentEntity
     * @param Eco $entity
     * @param GameResult $gameResult
     * @param EcoCollection $collection
     */
    public function take(Eco $currentEntity, Eco $entity, GameResult $gameResult, EcoCollection $collection): void
    {
        $currentEntity->take($entity);

        $this->logger->info(
            'Observer № ' . $currentEntity->getId() . ' take ' . $entity->getName(),
            $entity->getFields()
        );

        $gameResult->setFields(
            'Observer № ' . $currentEntity->getId() . ' take ' . $entity->getName(),
            $entity->getFields()
        );

        $collection->removeValue($entity);
    }
}