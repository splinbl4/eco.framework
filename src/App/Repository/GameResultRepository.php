<?php

namespace App\Repository;

use App\Entity\Game;
use App\Entity\GameResult;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method GameResult|null find($id, $lockMode = null, $lockVersion = null)
 * @method GameResult|null findOneBy(array $criteria, array $orderBy = null)
 * @method GameResult[]    findAll()
 * @method GameResult[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameResultRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, GameResult::class);
    }

    /**
     * @param Game $game
     * @return GameResult
     */
    public function getResultGame(Game $game)
    {
        return $this->createQueryBuilder('game_result')
            ->where('game_result.game = :game')
            ->setParameter('game', $game)
            ->getQuery()
            ->getResult();
    }
}
