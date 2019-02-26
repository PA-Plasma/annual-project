<?php

namespace App\Entity\Modules;

use App\Entity\Event;
use App\Entity\Interfaces\ModuleInterface;
use App\Entity\Traits\ActiveTrait;
use App\Entity\Traits\SoftDeletedTrait;
use App\Entity\Traits\TimestampableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Modules\ModuleTournamentRepository")
 */
class ModuleTournament implements ModuleInterface
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

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Modules\ModuleTournamentMatch", mappedBy="tournament", orphanRemoval=true)
     */
    private $Matches;

    public function __construct()
    {
        $this->Matches = new ArrayCollection();
    }

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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function isParameted() {
        return ($this->getModuleTournamentParameters() !== null) ? true : false;
    }

    /**
     * @return Collection|ModuleTournamentMatch[]
     */
    public function getMatches(): Collection
    {
        return $this->Matches;
    }

    public function addMatch(ModuleTournamentMatch $match): self
    {
        if (!$this->Matches->contains($match)) {
            $this->Matches[] = $match;
            $match->setTournament($this);
        }

        return $this;
    }

    public function removeMatch(ModuleTournamentMatch $match): self
    {
        if ($this->Matches->contains($match)) {
            $this->Matches->removeElement($match);
            // set the owning side to null (unless already changed)
            if ($match->getTournament() === $this) {
                $match->setTournament(null);
            }
        }

        return $this;
    }
}
