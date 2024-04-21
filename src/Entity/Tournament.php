<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\TournamentRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TournamentRepository::class)]
class Tournament
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['tournament:read'])]
    private ?string $tournamentName = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    #[Groups(['tournament:read'])]
    private ?\DateTimeInterface $startDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    #[Groups(['tournament:read'])]
    private ?\DateTimeInterface $endDate = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['tournament:read'])]
    private ?string $location = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['tournament:read'])]
    private ?string $description = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['tournament:read'])]
    private ?int $maxParticipants = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['tournament:read'])]
    private ?string $game = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['tournament:read'])]
    private ?string $status = null;

    #[ORM\OneToMany(targetEntity: Registration::class, mappedBy: 'tournament')]
    private Collection $registrations;

    #[ORM\OneToMany(targetEntity: Game::class, mappedBy: 'tournament')]
    private Collection $games;

    #[ORM\ManyToOne(inversedBy: 'tournaments')]
    private ?User $organizer = null;

    #[ORM\ManyToOne(inversedBy: 'tournamentsWins')]
    private ?User $winner = null;

    public function __construct()
    {
        $this->registrations = new ArrayCollection();
        $this->games = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTournamentName(): ?string
    {
        return $this->tournamentName;
    }

    public function setTournamentName(?string $tournamentName): static
    {
        $this->tournamentName = $tournamentName;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(?\DateTimeInterface $startDate): static
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTimeInterface $endDate): static
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getMaxParticipants(): ?int
    {
        return $this->maxParticipants;
    }

    public function setMaxParticipants(?int $maxParticipants): static
    {
        $this->maxParticipants = $maxParticipants;

        return $this;
    }

    public function getGame(): ?string
    {
        return $this->game;
    }

    public function setGame(?string $game): static
    {
        $this->game = $game;

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

    /**
     * @return Collection<int, Registration>
     */
    public function getRegistrations(): Collection
    {
        return $this->registrations;
    }

    public function addRegistration(Registration $registration): static
    {
        if (!$this->registrations->contains($registration)) {
            $this->registrations->add($registration);
            $registration->setTournament($this);
        }

        return $this;
    }

    public function removeRegistration(Registration $registration): static
    {
        if ($this->registrations->removeElement($registration)) {
            // set the owning side to null (unless already changed)
            if ($registration->getTournament() === $this) {
                $registration->setTournament(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Game>
     */
    public function getGames(): Collection
    {
        return $this->games;
    }

    public function addGame(Game $game): static
    {
        if (!$this->games->contains($game)) {
            $this->games->add($game);
            $game->setTournament($this);
        }

        return $this;
    }

    public function removeGame(Game $game): static
    {
        if ($this->games->removeElement($game)) {
            // set the owning side to null (unless already changed)
            if ($game->getTournament() === $this) {
                $game->setTournament(null);
            }
        }

        return $this;
    }

    public function getOrganizer(): ?User
    {
        return $this->organizer;
    }

    public function setOrganizer(?User $organizer): static
    {
        $this->organizer = $organizer;

        return $this;
    }

    public function getWinner(): ?User
    {
        return $this->winner;
    }

    public function setWinner(?User $winner): static
    {
        $this->winner = $winner;

        return $this;
    }

    public function __toString(): string
    {
        return $this->tournamentName;
    }
}
