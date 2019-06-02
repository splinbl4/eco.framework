<?php

namespace App\Service\Animal;

use App\Entity\Eco;
use App\Entity\GameResult;
use App\UseCase\Collection\EcoCollection;
use Psr\Log\LoggerInterface;

class AnimalService
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Взаимодействие животных с другими сущностями игры, а также запись в логи и базу этого взаимодействия
     *
     * @param Eco $currentEntity
     * @param Eco $entity
     * @param GameResult $gameResult
     * @param EcoCollection $collection
     */

    public function eat(Eco $currentEntity, Eco $entity, GameResult $gameResult, EcoCollection $collection): void
    {
        $currentEntity->eat($entity);

        $this->logger->info(
            $currentEntity->getName() . ' eat ' . $entity->getName(),
            $entity->getFields()
        );

        $gameResult->setFields($currentEntity->getName() . ' eat ' . $entity->getName(), $entity->getFields());

        $collection->removeValue($entity);
    }

}