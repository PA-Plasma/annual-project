<?php

namespace App\Entity\Modules;

use App\Entity\Event;
use App\Entity\Traits\ActiveTrait;
use App\Entity\Traits\SoftDeletedTrait;
use App\Entity\Traits\TimestampableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Modules\ModuleTeamRepository")
 */
class ModuleTeam
{
    use ActiveTrait, SoftDeletedTrait, TimestampableTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Event", inversedBy="moduleTeam", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $event;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Modules\ModuleTeamParameters", mappedBy="moduleTeam", cascade={"persist", "remove"})
     */
    private $moduleTeamParameters;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Modules\ModuleTeamInformation", mappedBy="moduleTeam", cascade={"persist"})
     */
    private $teams;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    public function __construct()
    {
        $this->teams = new ArrayCollection();
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

    public function getModuleTeamParameters(): ?ModuleTeamParameters
    {
        return $this->moduleTeamParameters;
    }

    public function setModuleTeamParameters(ModuleTeamParameters $moduleTeamParameters): self
    {
        $this->moduleTeamParameters = $moduleTeamParameters;

        // set the owning side of the relation if necessary
        if ($this !== $moduleTeamParameters->getModuleTeam()) {
            $moduleTeamParameters->setModuleTeam($this);
        }

        return $this;
    }

    /**
     * @return Collection|ModuleTeamInformation[]
     */
    public function getTeams(): Collection
    {
        return $this->teams;
    }

    public function addTeam(ModuleTeamInformation $team): self
    {
        if (!$this->teams->contains($team)) {
            $this->teams->add($team);;
            $team->setModuleTeam($this);
        }

        return $this;
    }

    public function removeTeam(ModuleTeamInformation $team): self
    {
        if ($this->teams->contains($team)) {
            $this->teams->removeElement($team);
            // set the owning side to null (unless already changed)
            if ($team->getModuleTeam() === $this) {
                $team->getModuleTeam()(null);
            }
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
        return ($this->getModuleTeamParameters() !== null) ? true : false;
    }
}
