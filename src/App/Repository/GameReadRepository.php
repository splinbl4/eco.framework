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
}
