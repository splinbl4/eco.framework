<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="games")
 */
class Game
{
    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", name="size_field")
     */
    private $sizeField;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", name="duration")
     */
    private $duration;

    /**
     * @var ArrayCollection|GameResult[]
     * @ORM\OneToMany(targetEntity="GameResult", mappedBy="game", orphanRemoval=true, cascade={"persist"})
     */
    private $gameResults;

    public function __construct()
    {
        $this->gameResults = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSizeField(): ?int
    {
        return $this->sizeField;
    }

    public function setSizeField(int $sizeField): self
    {
        $this->sizeField = $sizeField;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getGameResults(): array
    {
        return $this->gameResults->toArray();
    }

}
