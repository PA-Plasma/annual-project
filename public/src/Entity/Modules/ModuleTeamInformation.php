<?php

namespace App\Entity\Modules;

use App\Entity\Entrant;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Modules\ModuleTeamInformationRepository")
 */
class ModuleTeamInformation
{

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $teamName;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Modules\ModuleTeam", inversedBy="teams")
     * @ORM\JoinColumn(nullable=false)
     */
    private $moduleTeam;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Entrant", mappedBy="team")
     * @ORM\JoinColumn(nullable=true)
     */
    private $entrants;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $teamColor;

    public function __construct()
    {
        $this->entrants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Description getTeamName function
     *
     * @return mixed
     */
    public function getTeamName()
    {
        return $this->teamName;
    }

    /**
     * Description setTeamName function
     *
     * @param mixed $teamName
     *
     * @return void
     */
    public function setTeamName($teamName): void
    {
        $this->teamName = $teamName;
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

    /**
     * Description getTeamColor function
     *
     * @return mixed
     */
    public function getTeamColor()
    {
        return $this->teamColor;
    }

    /**
     * Description setTeamColor function
     *
     * @param mixed $teamColor
     *
     * @return void
     */
    public function setTeamColor($teamColor): void
    {
        $this->teamColor = $teamColor;
    }
}
