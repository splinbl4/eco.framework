<?php

namespace App\Service\Animal;

use App\Entity\GameResult;
use App\UseCase\Collection\EcoCollection;
use Psr\Log\LoggerInterface;

interface AnimalService
{
    /**
     * Взаимодействие хищника с другими сущностями игры, а также запись в логи и базу этого взаимодействия
     *
     * @param int $current
     * @param int $offset
     * @param EcoCollection $collection
     * @param LoggerInterface $log
     * @param GameResult $gameResult
     */
    public function eat(int $current, int $offset, EcoCollection $collection, LoggerInterface $log, GameResult $gameResult) :void;
}