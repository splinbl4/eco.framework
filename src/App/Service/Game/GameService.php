<?php

namespace App\Service\Game;

use App\Entity\Animal\Animal;
use App\Entity\Animal\Herbivore;
use App\Entity\Animal\LargePredator;
use App\Entity\Animal\SimplePredator;
use App\Entity\Game;
use App\Entity\Observer;
use App\Entity\GameResult;
use App\Entity\Plants\Plant;
use App\Service\Animal\AnimalService;
use App\Service\Observers\ObserverService;
use App\UseCase\Collection\EcoCollection;
use App\UseCase\Location;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

class GameService
{
    private $entityManager;
    private $logger;
    private $animalService;
    private $observerService;

    public function __construct(EntityManagerInterface $entityManager, LoggerInterface $logger)
    {
        $this->entityManager = $entityManager;
        $this->logger = $logger;
         $this->animalService = new AnimalService($logger);
        $this->observerService = new ObserverService($logger);
    }

    /**
     * Заполнение полей и создание игры
     *
     * @param Game $game
     * @param array $data
     */
    public function create(Game $game, array $data): void
    {
        $game->setSizeField($data['sizeField']);
        $game->setDuration($data['duration']);

        $this->entityManager->persist($game);
        $this->entityManager->flush();
    }

    /**
     * Вся логика игры здесь
     *
     * @param EcoCollection $collection
     * @param Location $location
     * @param Game $game
     * @throws \Exception
     */
    public function play(EcoCollection $collection, Location $location, Game $game): void
    {
        $this->logger->info('Start');

        $step = true;
        $count = 1;
        $durationObservation = $game->getDuration();

        while ($durationObservation !== 0 && $step === true) {
            $gameResult = new GameResult(new GameResultService($this->entityManager));
            $gameResult->setStep($count);
            $gameResult->setGame($game);

            foreach ($collection as $current => &$currentEntity) {
                foreach ($collection as $offset => &$entity) {
                    if ($entity->getIsEaten()) {
                        continue;
                    }
                    if ($offset !== $current && $collection->isOverlay($current, $offset)) {
                        if ($currentEntity instanceof Herbivore && $entity instanceof Plant) {
                            $this->animalService->eat($currentEntity, $entity, $gameResult, $collection);
                            $collection->add(new Plant($location, 'plants-' . $count));
                        }

                        if (($this->isPredator($currentEntity)) && $this->isAnimal($entity)) {
                            if ($currentEntity->isStronger($entity)) {
                                $this->animalService->eat($currentEntity, $entity, $gameResult, $collection);
                            }

                            if ($currentEntity->isEqual($entity)) {
                                $this->displacement($currentEntity, $entity, $gameResult);
                            }
                        }

                        if ($currentEntity instanceof Observer) {
                            if ($entity instanceof Plant) {
                                $this->observerService->take($currentEntity, $entity, $gameResult, $collection);
                            }

                            if (!$entity instanceof Observer && !$entity instanceof Plant) {
                                $this->logger->info(
                                    'Description of the observer №' . $currentEntity->getId(),
                                    $entity->getFields()
                                );

                                $gameResult->setFields(
                                    'Description of the observer №' . $currentEntity->getId(),
                                    $entity->getFields()
                                );
                            }
                        }
                    }
                }
                unset($entity);
            }
            unset($currentEntity);

            $step = $collection->checkType(Herbivore::class);
            $durationObservation--;
            $count++;

            $this->logger->info('step: ' . $count);

            $gameResult->gameResultService->create($gameResult);

            $collection->displacement();
        }

        $this->logger->info('End');
    }

    private function isPredator($instance): bool
    {
        if ($instance instanceof LargePredator || $instance instanceof SimplePredator) {
            return true;
        }

        return false;
    }

    private function isAnimal($entity): bool
    {
        if ($entity instanceof Animal) {
            return true;
        }

        return false;
    }

    /**
     * Сменить координаты сущности игры
     *
     * @param $currentEntity
     * @param $entity
     * @param GameResult $gameResult
     */
    private function displacement($currentEntity, $entity, GameResult $gameResult): void
    {
        $currentEntity->ecoService->displacement();
        $entity->ecoService->displacement();

        $this->logger->info($currentEntity->getName() . ' is equal ' . $entity->getName());
        $gameResult->setFields($currentEntity->getName() . ' is equal ' . $entity->getName());
    }
}