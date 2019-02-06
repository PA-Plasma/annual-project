<?php

namespace App\Entity\Modules;

use App\Entity\Event;
use App\Entity\Traits\ActiveTrait;
use App\Entity\Traits\SoftDeletedTrait;
use App\Entity\Traits\TimestampableTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Modules\ModuleTournamentRepository")
 */
class ModuleTournament
{
    use ActiveTrait, SoftDeletedTrait, TimestampableTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Event", inversedBy="moduleTournament", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $event;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Modules\ModuleTournamentParameters", mappedBy="moduleTournament", cascade={"persist", "remove"})
     */
    private $moduleTournamentParameters;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(Event $event): self
    {
        $this->event = $event;

        return $this;
    }

    public function getModuleTournamentParameters(): ?ModuleTournamentParameters
    {
        return $this->moduleTournamentParameters;
    }

    public function setModuleTournamentParameters(ModuleTournamentParameters $moduleTournamentParameters): self
    {
        $this->moduleTournamentParameters = $moduleTournamentParameters;

        // set the owning side of the relation if necessary
        if ($this !== $moduleTournamentParameters->getModuleTournament()) {
            $moduleTournamentParameters->setModuleTournament($this);
        }

        return $this;
    }
}
