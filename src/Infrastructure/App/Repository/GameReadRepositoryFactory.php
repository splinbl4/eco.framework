<?php

namespace Infrastructure\App\Repository;

use App\Entity\Game;
use App\Repository\GameReadRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Psr\Container\ContainerInterface;

class GameReadRepositoryFactory
{
    public function __invoke(ContainerInterface $container)
    {
        /**
         * @var EntityManagerInterface $em
         * @var EntityRepository $repository
         */
        $em = $container->get(EntityManagerInterface::class);
        $repository = $em->getRepository(Game::class);

        return new GameReadRepository($repository);
    }
}