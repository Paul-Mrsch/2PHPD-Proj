<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lasName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $firstName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $username = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $emailAdress = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $status = null;

    #[ORM\OneToMany(targetEntity: Tournament::class, mappedBy: 'organizer')]
    private Collection $tournaments;

    #[ORM\OneToMany(targetEntity: Tournament::class, mappedBy: 'winner')]
    private Collection $tournamentsWins;

    #[ORM\OneToMany(targetEntity: Registration::class, mappedBy: 'player')]
    private Collection $registrations;

    #[ORM\OneToMany(targetEntity: Game::class, mappedBy: 'player1')]
    private Collection $gamePlayer1;

    #[ORM\OneToMany(targetEntity: Game::class, mappedBy: 'player2')]
    private Collection $gamePlayer2;

    public function __construct()
    {
        $this->tournaments = new ArrayCollection();
        $this->tournamentsWins = new ArrayCollection();
        $this->registrations = new ArrayCollection();
        $this->gamePlayer1 = new ArrayCollection();
        $this->gamePlayer2 = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLasName(): ?string
    {
        return $this->lasName;
    }

    public function setLasName(?string $lasName): static
    {
        $this->lasName = $lasName;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getEmailAdress(): ?string
    {
        return $this->emailAdress;
    }

    public function setEmailAdress(?string $emailAdress): static
    {
        $this->emailAdress = $emailAdress;

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
     * @return Collection<int, Tournament>
     */
    public function getTournaments(): Collection
    {
        return $this->tournaments;
    }

    public function addTournament(Tournament $tournament): static
    {
        if (!$this->tournaments->contains($tournament)) {
            $this->tournaments->add($tournament);
            $tournament->setOrganizer($this);
        }

        return $this;
    }

    public function removeTournament(Tournament $tournament): static
    {
        if ($this->tournaments->removeElement($tournament)) {
            // set the owning side to null (unless already changed)
            if ($tournament->getOrganizer() === $this) {
                $tournament->setOrganizer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Tournament>
     */
    public function getTournamentsWins(): Collection
    {
        return $this->tournamentsWins;
    }

    public function addTournamentsWin(Tournament $tournamentsWin): static
    {
        if (!$this->tournamentsWins->contains($tournamentsWin)) {
            $this->tournamentsWins->add($tournamentsWin);
            $tournamentsWin->setWinner($this);
        }

        return $this;
    }

    public function removeTournamentsWin(Tournament $tournamentsWin): static
    {
        if ($this->tournamentsWins->removeElement($tournamentsWin)) {
            // set the owning side to null (unless already changed)
            if ($tournamentsWin->getWinner() === $this) {
                $tournamentsWin->setWinner(null);
            }
        }

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
            $registration->setPlayer($this);
        }

        return $this;
    }

    public function removeRegistration(Registration $registration): static
    {
        if ($this->registrations->removeElement($registration)) {
            // set the owning side to null (unless already changed)
            if ($registration->getPlayer() === $this) {
                $registration->setPlayer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Game>
     */
    public function getGamePlayer1(): Collection
    {
        return $this->gamePlayer1;
    }

    public function addGamePlayer1(Game $gamePlayer1): static
    {
        if (!$this->gamePlayer1->contains($gamePlayer1)) {
            $this->gamePlayer1->add($gamePlayer1);
            $gamePlayer1->setPlayer1($this);
        }

        return $this;
    }

    public function removeGamePlayer1(Game $gamePlayer1): static
    {
        if ($this->gamePlayer1->removeElement($gamePlayer1)) {
            // set the owning side to null (unless already changed)
            if ($gamePlayer1->getPlayer1() === $this) {
                $gamePlayer1->setPlayer1(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Game>
     */
    public function getGamePlayer2(): Collection
    {
        return $this->gamePlayer2;
    }

    public function addGamePlayer2(Game $gamePlayer2): static
    {
        if (!$this->gamePlayer2->contains($gamePlayer2)) {
            $this->gamePlayer2->add($gamePlayer2);
            $gamePlayer2->setPlayer2($this);
        }

        return $this;
    }

    public function removeGamePlayer2(Game $gamePlayer2): static
    {
        if ($this->gamePlayer2->removeElement($gamePlayer2)) {
            // set the owning side to null (unless already changed)
            if ($gamePlayer2->getPlayer2() === $this) {
                $gamePlayer2->setPlayer2(null);
            }
        }

        return $this;
    }
}
