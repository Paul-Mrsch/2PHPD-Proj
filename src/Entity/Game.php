<?php

namespace App\Entity;

use App\Repository\GameRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GameRepository::class)]
class Game
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $gameDate = null;

    #[ORM\Column(nullable: true)]
    private ?int $scorePlayer1 = null;

    #[ORM\Column(nullable: true)]
    private ?int $scorePlayer2 = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGameDate(): ?\DateTimeInterface
    {
        return $this->gameDate;
    }

    public function setGameDate(?\DateTimeInterface $gameDate): static
    {
        $this->gameDate = $gameDate;

        return $this;
    }

    public function getScorePlayer1(): ?int
    {
        return $this->scorePlayer1;
    }

    public function setScorePlayer1(?int $scorePlayer1): static
    {
        $this->scorePlayer1 = $scorePlayer1;

        return $this;
    }

    public function getScorePlayer2(): ?int
    {
        return $this->scorePlayer2;
    }

    public function setScorePlayer2(?int $scorePlayer2): static
    {
        $this->scorePlayer2 = $scorePlayer2;

        return $this;
    }
}
