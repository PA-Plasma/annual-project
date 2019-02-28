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
     * @ORM\Column(type="integer")
     */
    private $nbEntrants;

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
     * Description getNbEntrants function
     *
     * @return mixed
     */
    public function getNbEntrants()
    {
        return $this->nbEntrants;
    }

    /**
     * Description setNbEntrants function
     *
     * @param mixed $nbEntrants
     *
     * @return void
     */
    public function setNbEntrants($nbEntrants): void
    {
        $this->nbEntrants = $nbEntrants;
    }
}
