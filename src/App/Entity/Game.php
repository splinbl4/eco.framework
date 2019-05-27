<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GameRepository")
 */
class Game
{
    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $sizeField;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $duration;

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
}
