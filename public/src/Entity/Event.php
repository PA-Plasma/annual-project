<?php

namespace App\Entity;

use App\Entity\Traits\ActiveTrait;
use App\Entity\Traits\SoftDeletedTrait;
use App\Entity\Traits\TimestampableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventRepository")
 */
class Event
{
    CONST REGISTRATION_TYPE_FREE = 1;
    CONST REGISTRATION_TYPE_PAYING = 2;

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
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="datetime")
     */
    private $beginnig_date;

    /**
     * @ORM\Column(type="datetime")
     */
    private $end_date;

    /**
     * @ORM\Column(type="integer")
     */
    private $registration_type;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Entrant", mappedBy="event", cascade={"persist"})
     */
    private $entrants;

    /**
     * @ORM\Column(type="boolean")
     */
    private $invitation;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Address", inversedBy="event", cascade={"persist", "remove"})
     */
    private $Address;

    /**
     * @var string
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(type="string", nullable=true)
     */
    private $slug = null;

    public function __construct()
    {
        $this->entrants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getBeginnigDate(): ?\DateTimeInterface
    {
        return $this->beginnig_date;
    }

    public function setBeginnigDate(\DateTimeInterface $beginnig_date): self
    {
        $this->beginnig_date = $beginnig_date;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->end_date;
    }

    public function setEndDate(\DateTimeInterface $end_date): self
    {
        $this->end_date = $end_date;

        return $this;
    }

    public function getRegistrationType(): ?int
    {
        return $this->registration_type;
    }

    public function setRegistrationType(int $registration_type): self
    {
        $this->registration_type = $registration_type;

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
            $entrant->setEvent($this);
        }

        return $this;
    }

    public function removeEntrant(Entrant $entrant): self
    {
        if ($this->entrants->contains($entrant)) {
            $this->entrants->removeElement($entrant);
            // set the owning side to null (unless already changed)
            if ($entrant->getEvent() === $this) {
                $entrant->setEvent(null);
            }
        }

        return $this;
    }

    public function getInvitation(): ?bool
    {
        return $this->invitation;
    }

    public function setInvitation(bool $invitation): self
    {
        $this->invitation = $invitation;

        return $this;
    }

    public function getAddress(): ?Address
    {
        return $this->Address;
    }

    public function setAddress(?Address $Address): self
    {
        $this->Address = $Address;

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
}
