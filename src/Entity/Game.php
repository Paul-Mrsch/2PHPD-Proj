<?php

namespace App\Entity;

use App\Repository\GameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $status = null;

    #[ORM\ManyToOne(inversedBy: 'games')]
    private ?Tournament $tournament = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'games')]
    private Collection $player;

    public function __construct()
    {
        $this->player = new ArrayCollection();
    }

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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getTournament(): ?Tournament
    {
        return $this->tournament;
    }

    public function setTournament(?Tournament $tournament): static
    {
        $this->tournament = $tournament;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getGamePlayer(): Collection
    {
        return $this->player;
    }

    public function addGamePlayer(User $player): static
    {
        if (!$this->player->contains($player)) {
            $this->player->add($player);
        }

        return $this;
    }

    public function removeGamePlayer(User $player): static
    {
        $this->player->removeElement($player);

        return $this;
    }
}
