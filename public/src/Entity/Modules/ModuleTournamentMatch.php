<?php

namespace App\Entity\Modules;

use App\Entity\Entrant;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Modules\ModuleTournamentMatchRepository")
 */
class ModuleTournamentMatch
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $round;

    /**
     * @ORM\Column(type="integer")
     */
    private $number;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Entrant", inversedBy="moduleTournamentMatches")
     */
    private $players;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Modules\ModuleTournament", inversedBy="Matches")
     * @ORM\JoinColumn(nullable=false)
     */
    private $tournament;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Modules\ModuleTournamentMatchScore", mappedBy="match", orphanRemoval=true)
     */
    private $scores;

    public function __construct()
    {
        $this->players = new ArrayCollection();
        $this->scores = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRound(): ?int
    {
        return $this->round;
    }

    public function setRound(int $round): self
    {
        $this->round = $round;

        return $this;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): self
    {
        $this->number = $number;

        return $this;
    }

    /**
     * @return Collection|Entrant[]
     */
    public function getPlayers(): Collection
    {
        return $this->players;
    }

    public function addPlayer(Entrant $player): self
    {
        if (!$this->players->contains($player)) {
            $this->players[] = $player;
        }

        return $this;
    }

    public function removePlayer(Entrant $player): self
    {
        if ($this->players->contains($player)) {
            $this->players->removeElement($player);
        }

        return $this;
    }

    public function getTournament(): ?ModuleTournament
    {
        return $this->tournament;
    }

    public function setTournament(?ModuleTournament $tournament): self
    {
        $this->tournament = $tournament;

        return $this;
    }

    /**
     * @return Collection|ModuleTournamentMatchScore[]
     */
    public function getScores(): Collection
    {
        return $this->scores;
    }

    public function addScore(ModuleTournamentMatchScore $score): self
    {
        if (!$this->scores->contains($score)) {
            $this->scores[] = $score;
            $score->setMatch($this);
        }

        return $this;
    }

    public function removeScore(ModuleTournamentMatchScore $score): self
    {
        if ($this->scores->contains($score)) {
            $this->scores->removeElement($score);
            // set the owning side to null (unless already changed)
            if ($score->getMatch() === $this) {
                $score->setMatch(null);
            }
        }

        return $this;
    }
}
