<?php

namespace App\Entity;

use App\Entity\Modules\ModuleTournamentMatch;
use App\Entity\Modules\ModuleTournamentMatchScore;
use App\Entity\Traits\ActiveTrait;
use App\Entity\Traits\SoftDeletedTrait;
use App\Entity\Traits\TimestampableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EntrantRepository")
 */
class Entrant
{
    use ActiveTrait;
    use SoftDeletedTrait;
    use TimestampableTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="entrants")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user_related;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Event", inversedBy="entrants")
     * @ORM\JoinColumn(nullable=false)
     */
    private $event;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pseudo;

    /**
     * @var string
     * @Gedmo\Slug(fields={"pseudo"})
     * @ORM\Column(type="string", nullable=true)
     */
    private $slug = null;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Modules\ModuleTournamentMatch", mappedBy="players")
     */
    private $moduleTournamentMatches;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Modules\ModuleTournamentMatchScore", mappedBy="player")
     */
    private $moduleTournamentMatchScores;

    public function __construct()
    {
        $this->moduleTournamentMatches = new ArrayCollection();
        $this->moduleTournamentMatchScores = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserRelated(): ?User
    {
        return $this->user_related;
    }

    public function setUserRelated(?User $user_related): self
    {
        $this->user_related = $user_related;

        return $this;
    }

    public function getEvent(): Event
    {
        return $this->event;
    }

    public function setEvent(Event $event): self
    {
        $this->event = $event;

        return $this;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    /**
     * @return Collection|ModuleTournamentMatch[]
     */
    public function getModuleTournamentMatches(): Collection
    {
        return $this->moduleTournamentMatches;
    }

    public function addModuleTournamentMatch(ModuleTournamentMatch $moduleTournamentMatch): self
    {
        if (!$this->moduleTournamentMatches->contains($moduleTournamentMatch)) {
            $this->moduleTournamentMatches[] = $moduleTournamentMatch;
            $moduleTournamentMatch->addPlayer($this);
        }

        return $this;
    }

    public function removeModuleTournamentMatch(ModuleTournamentMatch $moduleTournamentMatch): self
    {
        if ($this->moduleTournamentMatches->contains($moduleTournamentMatch)) {
            $this->moduleTournamentMatches->removeElement($moduleTournamentMatch);
            $moduleTournamentMatch->removePlayer($this);
        }

        return $this;
    }

    /**
     * @return Collection|ModuleTournamentMatchScore[]
     */
    public function getModuleTournamentMatchScores(): Collection
    {
        return $this->moduleTournamentMatchScores;
    }

    public function addModuleTournamentMatchScore(ModuleTournamentMatchScore $moduleTournamentMatchScore): self
    {
        if (!$this->moduleTournamentMatchScores->contains($moduleTournamentMatchScore)) {
            $this->moduleTournamentMatchScores[] = $moduleTournamentMatchScore;
            $moduleTournamentMatchScore->setPlayer($this);
        }

        return $this;
    }

    public function removeModuleTournamentMatchScore(ModuleTournamentMatchScore $moduleTournamentMatchScore): self
    {
        if ($this->moduleTournamentMatchScores->contains($moduleTournamentMatchScore)) {
            $this->moduleTournamentMatchScores->removeElement($moduleTournamentMatchScore);
            // set the owning side to null (unless already changed)
            if ($moduleTournamentMatchScore->getPlayer() === $this) {
                $moduleTournamentMatchScore->setPlayer(null);
            }
        }

        return $this;
    }
}
