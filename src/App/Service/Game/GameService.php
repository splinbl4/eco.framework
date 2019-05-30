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
use App\UseCase\Collection\EcoCollection;
use App\UseCase\Location;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

class GameService
{
    private $entityManager;
    private $logger;

    public function __construct(EntityManagerInterface $entityManager, LoggerInterface $logger)
    {
        $this->entityManager = $entityManager;
        $this->logger = $logger;
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

            foreach ($collection as $current => &$item) {
                if ($item->getIsEaten()) {
                    continue;
                }
                foreach ($collection as $offset => &$value) {
                    if ($offset !== $current && $collection->isOverlay($current, $offset)) {
                        if ($item instanceof Herbivore && $value instanceof Plant) {
                            $item->animalService->eat($current, $offset, $collection, $this->logger, $gameResult);
                            $collection->add(new Plant($location, '$plants'));
                        }

                        if (($item instanceof LargePredator || $item instanceof SimplePredator) && $value instanceof Animal) {
                            if ($item->isStronger($value)) {
                                $item->animalService->eat($current, $offset, $collection, $this->logger, $gameResult);
                            }

                            if ($item->isEqual($value)) {
                                $item->ecoService->displacement();
                                $value->ecoService->displacement();

                                $this->logger->info($item->getName() . ' is equal ' . $value->getName());
                                $gameResult->setFields($item->getName() . ' is equal ' . $value->getName());
                            }
                        }

                        if ($item instanceof Observer) {
                            if ($value instanceof Plant) {
                                $item->observerService->take($current, $offset, $collection, $this->logger, $gameResult);
                            }

                            if (!$value instanceof Observer && !$value instanceof Plant) {
                                $this->logger->info(
                                    'Description of the observer №' . $item->getId(),
                                    $value->getFields()
                                );

                                $gameResult->setFields(
                                    'Description of the observer №' . $item->getId(),
                                    $value->getFields()
                                );
                            }
                        }
                    }
                }
                unset($value);
            }
            unset($item);

            $step = $collection->checkType(Herbivore::class);
            $durationObservation--;
            $count++;

            $this->logger->info('step: ' . $count);

            $gameResult->gameResultService->create($gameResult);

            $collection->displacement();
        }

        $this->logger->info('End');
    }
}