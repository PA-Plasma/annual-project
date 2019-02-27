<?php

namespace App\Entity\Modules;

use App\Entity\Entrant;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Modules\ModuleTeamParametersRepository")
 */
class ModuleTeamParameters
{

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Modules\ModuleTeam", inversedBy="moduleTeamParameters", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $moduleTeam;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Entrant", mappedBy="team")
     * @ORM\JoinColumn(nullable=false)
     */
    private $entrants;

    public function __construct()
    {
        $this->entrants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getModuleTeam(): ?ModuleTeam
    {
        return $this->moduleTeam;
    }

    public function setModuleTeam(ModuleTeam $moduleTeam): self
    {
        $this->moduleTeam = $moduleTeam;

        return $this;
    }

    /**
     * Description getName function
     *
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Description setName function
     *
     * @param mixed $name
     *
     * @return void
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    public function getEntrants(): Collection
    {
        return $this->entrants;
    }

    public function addEntrant(Entrant $entrant): self
    {
        if (!$this->entrants->contains($entrant)) {
            $this->entrants->add($entrant);
            $entrant->setTeam($this);
        }

        return $this;
    }

    public function removeEntrant(Entrant $entrant): self
    {
        if ($this->entrants->contains($entrant)) {
            $this->entrants->removeElement($entrant);
            // set the owning side to null (unless already changed)
            if ($entrant->getTeam() === $this) {
                $entrant->setTeam(null);
            }
        }

        return $this;
    }
}
