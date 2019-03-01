<?php

namespace App\Entity\Modules;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Modules\ModuleTournamentParametersRepository")
 */
class ModuleTournamentParameters
{
    const BRACKET_TYPE_1 = 1;
    const BRACKET_TYPE_2 = 2;
    const STAGE_TYPE_1 = 1;
    const STAGE_TYPE_2 = 2;
    const BO3 = 1;
    const BO5 = 2;
    const BO7 = 3;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $bracketType;

    /**
     * @ORM\Column(type="integer")
     */
    private $stageType;

    /**
     * @ORM\Column(type="integer")
     */
    private $playerFormatDefault;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Modules\ModuleTournament", inversedBy="moduleTournamentParameters", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $moduleTournament;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBracketType(): ?int
    {
        return $this->bracketType;
    }

    public function setBracketType(int $bracketType): self
    {
        $this->bracketType = $bracketType;

        return $this;
    }

    public function getStageType(): ?int
    {
        return $this->stageType;
    }

    public function setStageType(int $stageType): self
    {
        $this->stageType = $stageType;

        return $this;
    }

    public function getPlayerFormatDefault(): ?int
    {
        return $this->playerFormatDefault;
    }

    public function setPlayerFormatDefault(int $playerFormatDefault): self
    {
        $this->playerFormatDefault = $playerFormatDefault;

        return $this;
    }

    public function getModuleTournament(): ?ModuleTournament
    {
        return $this->moduleTournament;
    }

    public function setModuleTournament(ModuleTournament $moduleTournament): self
    {
        $this->moduleTournament = $moduleTournament;

        return $this;
    }
}
