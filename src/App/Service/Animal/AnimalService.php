<?php

namespace App\Service\Animal;

use App\Entity\GameResult;
use App\UseCase\Collection\EcoCollection;
use Psr\Log\LoggerInterface;

interface AnimalService
{
    public function eat(int $current, int $offset, EcoCollection $collection, LoggerInterface $log, GameResult $gameResult) :void;
}