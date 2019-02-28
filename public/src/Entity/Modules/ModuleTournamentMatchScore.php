<?php

namespace App\Entity\Modules;

use App\Entity\Entrant;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Modules\ModuleTournamentMatchScoreRepository")
 */
class ModuleTournamentMatchScore
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
    private $score;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Modules\ModuleTournamentMatch", inversedBy="scores")
     * @ORM\JoinColumn(nullable=false)
     */
    private $match;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Entrant", inversedBy="moduleTournamentMatchScores")
     */
    private $player;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(int $score): self
    {
        $this->score = $score;

        return $this;
    }

    public function getMatch(): ?ModuleTournamentMatch
    {
        return $this->match;
    }

    public function setMatch(?ModuleTournamentMatch $match): self
    {
        $this->match = $match;

        return $this;
    }

    public function getPlayer(): ?Entrant
    {
        return $this->player;
    }

    public function setPlayer(?Entrant $player): self
    {
        $this->player = $player;

        return $this;
    }
}
