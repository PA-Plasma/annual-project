<?php

namespace App\Entity\Modules;

use Doctrine\ORM\Mapping as ORM;

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
}
