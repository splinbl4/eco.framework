<?php

namespace App\Service\Game;

use App\Entity\GameResult;
use Doctrine\ORM\EntityManagerInterface;

class GameResultService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Создание результата игры
     *
     * @param GameResult $gameResult
     */
    public function create(GameResult $gameResult): void
    {
        $this->entityManager->persist($gameResult);
        $this->entityManager->flush();
    }
}