<?php

namespace App\Entity;

use App\Service\GameResult\GameResultService;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GameResultRepository")
 */
class GameResult
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
    private $step;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $message = '';

    /**
     * @var array
     *
     * @ORM\Column(type="array", nullable=true)
     */
    private $fields = [];

    /**
     * @var Game
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Game")
     */
    protected $game;

    /**
     * @var GameResultService
     */
    public $gameResultService;

    public function __construct(GameResultService $gameResultService)
    {
        $this->gameResultService = $gameResultService;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStep()
    {
        return $this->step;
    }

    public function setStep(int $step): self
    {
        $this->step = $step;

        return $this;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getFields(): array
    {
        return $this->fields;
    }

    public function setFields(string $message, array $fields = []): self
    {
        $this->fields[$message] = $fields;

        return $this;
    }

    public function getGame(): Game
    {
        return $this->game;
    }

    public function setGame(Game $game): self
    {
        $this->game = $game;

        return $this;
    }
}