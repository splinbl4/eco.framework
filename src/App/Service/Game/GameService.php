<?php

namespace App\Service\Game;

use App\Collection\EcoCollection;
use App\Collection\ResponseCollection;
use App\Entity\Animal;
use App\Entity\Game;
use App\Entity\Herbivore;
use App\Entity\LargePredator;
use App\Entity\Observer;
use App\Entity\Plant;
use App\Entity\GameResult;
use App\Entity\SimplePredator;
use App\Service\Location;
use App\UseCase\GameResult\GameResultService;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;

class GameService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
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
     * @param EcoCollection $collection
     * @param Location $location
     * @param Game $game
     * @throws \Exception
     */
/*    public function play(EcoCollection $collection, Location $location, Game $game): void
    {
        $log = $this->container->get('monolog.logger.profiler');
        $log->info('Start');

        $step = true;
        $count = 1;
        $durationObservation = $game->getDuration();

        while ($durationObservation !== 0 && $step === true) {
            $response = new GameResult(new GameResultService($this->container));
            $response->setStep($count);
            $response->setGame($game);

            foreach ($collection as $current => &$item) {
                if ($item->getIsEaten()) {
                    continue;
                }
                foreach ($collection as $offset => &$value) {
                    if ($offset !== $current && $collection->isOverlay($current, $offset)) {
                        if ($item instanceof Herbivore && $value instanceof Plant) {
                            $item->animalService->eat($current, $offset, $collection, $log, $response);
                            $collection->add(new Plant($location, '$plants'));
                        }

                        if (($item instanceof LargePredator || $item instanceof SimplePredator) && $value instanceof Animal) {
                            if ($item->isStronger($value)) {
                                $item->animalService->eat($current, $offset, $collection, $log, $response);
                            }

                            if ($item->isEqual($value)) {
                                $item->ecoService->displacement();
                                $value->ecoService->displacement();

                                $log->info($item->getName() . ' is equal ' . $value->getName());
                                $response->setFields($item->getName() . ' is equal ' . $value->getName());
                            }
                        }

                        if ($item instanceof Observer) {
                            if ($value instanceof Plant) {
                                $item->observerService->take($current, $offset, $collection, $log, $response);
                            }

                            if (!$value instanceof Observer && !$value instanceof Plant) {
                                $log->info(
                                    'Description of the observer №' . $item->getId(),
                                    $value->getFields()
                                );

                                $response->setFields(
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

            $step = $collection->checkType('App\Entity\Herbivore');
            $durationObservation--;
            $count++;

            $log->info('step: ' . $count);

            $response->gameResultService->create($response);
            unset($response);
            $collection->displacement();
        }
        $log->info('End');
    }*/
}