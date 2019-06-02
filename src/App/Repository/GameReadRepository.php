<?php

namespace App\Repository;

use App\Entity\Game;
use Doctrine\ORM\EntityRepository;

class GameReadRepository
{
    private $repository;

    public function __construct(EntityRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param int $id
     * @return Game|object|null
     */
    public function find(int $id): ?Game
    {
        return $this->repository->find($id);
    }

    public function countAll(): int
    {
        return $this->repository
            ->createQueryBuilder('g')
            ->select('COUNT(g)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * @param int $offset
     * @param int $limit
     * @return Game[]
     */
    public function all(int $offset, int $limit): array
    {
        return $this->repository
            ->createQueryBuilder('g')
            ->select('g')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->orderBy('g.id', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
